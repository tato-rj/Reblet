/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/js/utilities/dragdrop.js ***!
  \********************************************/
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

var DragDrop = /*#__PURE__*/function () {
  function DragDrop(params) {
    _classCallCheck(this, DragDrop);

    this.formId = params.formId;
    this.method = params.method;
    this.maxFilesize = params.maxFilesize;
    this.parallelUploads = params.parallelUploads;
    this.thumbPath = params.thumbPath;
  }

  _createClass(DragDrop, [{
    key: "run",
    value: function run() {
      var obj = this;
      Dropzone.autoDiscover = false;
      var dropzone = new Dropzone(obj.formId, {
        method: obj.method,
        url: '#',
        maxFilesize: obj.maxFilesize,
        // MB
        parallelUploads: obj.parallelUploads,
        dictDefaultMessage: '',
        headers: {},
        accept: function accept(file, next) {
          obj._checkForDuplicate(file).then(function (response) {
            var fileExists = response.data;

            if (!fileExists || confirm('This file already exists. Do you want to replace it?')) {
              obj._uploadFile(file, next);
            } else {
              dropzone.removeFile(file);
            }
          });
        },
        sending: function sending(file, xhr) {
          var _send = xhr.send;
          xhr.setRequestHeader('x-amz-acl', 'public-read');

          xhr.send = function () {
            _send.call(xhr, file);
          };
        },
        processing: function processing(file) {
          this.options.url = file.signedRequest;
          log(file.signedRequest);
        },
        init: function init() {
          var _this = this;

          this.on('addedfile', function (file) {
            obj._getIcon(file, _this);
          }); // this.on("sending", file => {});
          // this.on("error", (file, error) => {});

          this.on("success", function (file) {
            obj._saveFile();
          }); // this.on("complete", (file) => {});
          // this.on('thumbnail', (file, thumbnail) => {})
        },
        error: function error(file, _error) {
          log('ERROR: ' + _error);
        }
      });
      return obj;
    }
  }, {
    key: "_getPresignedUrl",
    value: function _getPresignedUrl(file) {
      var params = {
        path: $(this.formId).data('path'),
        name: file.name
      };
      return axios.post($(this.formId).attr('presignedUrl'), params);
    }
  }, {
    key: "_checkForDuplicate",
    value: function _checkForDuplicate(file) {
      log(file.name);
      return axios.get($(this.formId).attr('checkFile'), {
        params: {
          name: file.name
        }
      });
    }
  }, {
    key: "_uploadFile",
    value: function _uploadFile(file, next) {
      var obj = this;

      obj._getPresignedUrl(file).then(function (response) {
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
      })["catch"](function (error) {
        next('Could not get the presigned url.');
      });
    }
  }, {
    key: "_saveFile",
    value: function _saveFile() {
      var $form = $(this.formId);
      axios.post($form.attr('saveFile'), this.file).then(function (response) {
        $('.revision-tab.active .files-container').html(response.data);
      });
    }
  }, {
    key: "_getIcon",
    value: function _getIcon(file, dropzone) {
      var extensions = ['pdf', 'doc', 'docx', 'dwg', 'ai', 'afdesign'];
      var file_ext = file.name.split('.').pop();
      var file_type = file.type.split('/').shift();
      var thumbnail;

      if (file_type == 'image') {
        thumbnail = file.url;
      } else if (extensions.includes(file_ext)) {
        thumbnail = this.thumbPath + file_ext + ".svg";
      } else {
        thumbnail = this.thumbPath + "default.svg";
      }

      if (typeof thumbnail != 'undefined') dropzone.emit('thumbnail', file, thumbnail);
    }
  }]);

  return DragDrop;
}();

window.DragDrop = DragDrop;
var dragdrop;
$('#revisions-tab [data-bs-toggle="tab"]').on('show.bs.tab', function (event) {
  var $tab = $(event.target);
  axios.get($tab.data('dropzone')).then(function (response) {
    $('.dropzone-container').remove();
    $($tab.attr('href')).prepend(response.data);
    newDropzone();
  })["catch"](function (error) {
    console.log(error);
  });
});
newDropzone();

function newDropzone() {
  var formId = '#' + $('.dropzone').attr('id');
  dragdrop = new DragDrop({
    formId: formId,
    thumbPath: '/images/file_icons/',
    method: 'PUT',
    maxFilesize: 1000,
    parallelUploads: 2
  }).run();
}
/******/ })()
;