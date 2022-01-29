class DragDrop
{
	constructor(params)
	{
		this.formId = params.formId;
		this.method = params.method;
		this.maxFilesize = params.maxFilesize;
		this.parallelUploads = params.parallelUploads;
		this.thumbPath = params.thumbPath;
	}

	run()
	{
		let obj = this;
		
		Dropzone.autoDiscover = false;

		let dropzone = new Dropzone(obj.formId, {
			method: obj.method,
			url: '#',
			maxFilesize: obj.maxFilesize, // MB
			parallelUploads: obj.parallelUploads,
			dictDefaultMessage: '',
		    headers: {},
		    accept: function(file, next) {
		    	obj._checkForDuplicate(file)
		    		.then(function(response) {
		    			let fileExists = response.data;
			    		if (! fileExists || confirm('This file already exists. Do you want to replace it?')) {
			    			obj._uploadFile(file, next);
			    		} else {
			    			dropzone.removeFile(file);
			    		}
		    		});
		    },
		    sending: function(file, xhr) {
		        var _send = xhr.send;
		        xhr.setRequestHeader('x-amz-acl', 'public-read');
		        xhr.send = function() {
		            _send.call(xhr, file);
		        }
		    },
		    processing: function(file) {
		        this.options.url = file.signedRequest;
		        log(file.signedRequest);
		    },
			init: function() {
				this.on('addedfile', file => {
					obj._getIcon(file, this);
				});
				// this.on("sending", file => {});
				// this.on("error", (file, error) => {});
				this.on("success", (file) => {
					obj._saveFile();
				});
				// this.on("complete", (file) => {});
				// this.on('thumbnail', (file, thumbnail) => {})
			},
			error: function(file, error) {
				log('ERROR: '+error);
			}
		});

		return obj;
	}

	_getPresignedUrl(file)
	{
		let params = {
			path: $(this.formId).data('path'),
			name: file.name
		};

		return axios.post($(this.formId).attr('presignedUrl'), params);
	}

	_checkForDuplicate(file)
	{
		log(file.name);
		return axios.get($(this.formId).attr('checkFile'), {params: {name: file.name}})
	}

	_uploadFile(file, next)
	{
		let obj = this;

    	obj._getPresignedUrl(file)
    	 .then(function(response) {
    	 	obj.file = {
    	 		path: response.data.path, 
    	 		name: response.data.name,
    	 		originalName: file.name,
    	 		type: file.type, 
    	 		size: file.size,
    	 		given_name: file.name.split('.').shift()
    	 	};

    	 	file.signedRequest = response.data.url;
    	 	next();
    	 })
    	 .catch(function(error) { next('Could not get the presigned url.'); });
	}

	_saveFile()
	{
		let $form = $(this.formId);

		axios.post($form.attr('saveFile'), this.file)
			.then(function(response) {
			 	$('.revision-tab.active .files-container').html(response.data);
			});
	}

	_getIcon(file, dropzone)
	{
		let extensions = ['pdf', 'doc', 'docx', 'dwg', 'ai', 'afdesign'];
		let file_ext = file.name.split('.').pop();
		let file_type = file.type.split('/').shift();
		let thumbnail;

		if (file_type == 'image') {
			thumbnail = file.url;
		} else if (extensions.includes(file_ext)) {
			thumbnail = this.thumbPath + file_ext + ".svg";
		} else {
			thumbnail = this.thumbPath + "default.svg";
		}

		if (typeof thumbnail != 'undefined')
			dropzone.emit('thumbnail', file, thumbnail);
	}
}

window.DragDrop = DragDrop;

let dragdrop;

$('#revisions-tab [data-bs-toggle="tab"]').on('show.bs.tab', function(event) {
	let $tab = $(event.target);
	axios.get($tab.data('dropzone'))
		 .then(function(response) {
		 	$('.dropzone-container').remove();
		 	$($tab.attr('href')).prepend(response.data);
		 	newDropzone();
		 })
		 .catch(function(error) {
		 	console.log(error);
		 });
});

newDropzone();

function newDropzone()
{
	let formId = '#'+$('.dropzone').attr('id');

	dragdrop = new DragDrop({
		formId: formId,
		thumbPath: '/images/file_icons/',
		method: 'PUT',
		maxFilesize: 1000,
		parallelUploads: 2,
	}).run();
}