<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">

        <title>{{$title ?? 'Welcome'}} | {{config('app.name')}}</title>

        @include('layouts.components.favicon')
        @include('layouts.components.seo')

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <style type="text/css">
            .nav-link.highlight {
                color: blue!important;
            }

            .comments-dropdown {
                position: absolute;
                right: 0;
                background: white;
                display: none;
            }
        </style>

        <script type="text/javascript">
            window.unreadComments = <?php echo json_encode(request('panel')) ?>

            window.project = <?php echo isset($project) ? json_encode([
                'id' => $project->id,
                'team' => $project->team
                ]) : json_encode(null) ?>
        </script>
        @stack('header')
    </head>
    <body>
        <div id="window-overlay" class="window-overlay"></div>
        
        @include('layouts.header')

        <div id="page-content">
            <div class="pt-3 pb-5">
                @yield('content')
            </div>
        </div>

        @include('layouts.components.alerts')

        <script src="{{ mix('js/app.js') }}"></script>
        
        <script type="text/javascript">
            (new Overlay({
                element: '#window-overlay',
                speed: 'fast'
            })).run();

            (new Clipboard({
                element: '[data-clipboard-text], [data-clipboard-target]',
                success: 'Copied!',
                error: 'Failed...'
            })).run();


            let dynamicClip = new ClipboardJS('[data-dynamic-clipboard-text]', {
                text: function(elem) {
                    return elem.getAttribute('data-dynamic-clipboard-text');
                }
            });

            dynamicClip.on('success', function(e) {
                showTooltip(e.trigger, 'Copied!');
                hideTooltip(e.trigger);
            });

            dynamicClip.on('error', function(e) {
                showTooltip(e.trigger, 'Failed...');
                hideTooltip(e.trigger);
            });

            function showTooltip(elem, message)
            {
                $(elem).attr('title', message);
                $(elem).tooltip('show');
            }

            function hideTooltip(elem)
            {
                setTimeout(function() {
                    bootstrap.Tooltip.getInstance(elem).hide();
                }, 500);
            }

            $(document).on('mouseenter', '[data-toggle="tooltip"]', function() {
                $(this).tooltip('show');
            });

            $(document).on('click', '[data-toggle="tooltip"]', function() {
                $(this).tooltip('hide');
            });
        </script>

<script type="text/javascript">
$(document).on('submit', 'form.chat-form', function(e) {
    e.preventDefault();

    let $form = $(this);
    let url = $form.attr('action');
    let $button = $form.find('.btn[type="submit"]');
    let $textarea = $form.find('textarea[name="content"]');
    let params = {
        content: $textarea.val(),
        model_type: $form.find('input[name="model_type"]').val(),
        model_id: $form.find('input[name="model_id"]').val()
    };

    $button.addLoader();

    axios.post(url, params)
         .then(function(response) {
            $form.siblings('.comments-container').html(response.data);
         })
         .catch(function(error) {
            console.log(error);
         })
         .then(function() {
            $textarea.val('');
            $button.removeLoader();
        });
});

function showAlert(animation)
{
    let $container = $('#comments-notification');
    let $link = $container.find('.nav-link');

    $link.addClass('highlight animate__repeat-2 animate__slower animate__'+animation);

    $link.find('i').removeClass('fa-envelope').addClass('fa-envelope-open-text');

    setTimeout(function() {
        $link.removeClass('animate__repeat-2 animate__slower animate__'+animation);
    }, 200);
}

function hideAlert(animation)
{
    let $container = $('#comments-notification');
    let $link = $container.find('.nav-link');

    $link.removeClass('highlight animate__repeat-2 animate__slower animate__'+animation);

    $link.find('i').addClass('fa-envelope').removeClass('fa-envelope-open-text');
}

$('#comments-notification .nav-link').click(function() {
    let $dropdown = $('#comments-notification').find('.comments-dropdown');

    $dropdown.toggle();
});

$(document).ready(function() {
    if (! unreadComments)
        alertUnreadComments();
});

function alertUnreadComments()
{
    if ($('#comments-notification').length) {
    axios.get($('#comments-notification').data('url'))
         .then(function(response) {
            if (response.data) {
                showAlert('shakeY');
                $('#comments-notification .comments-dropdown').html(response.data);
            }
         });
    }
}

// BROADCAST COMMENTS LIVE TO OTHER USERS
if (project) {
    window.Echo.private('comments.'+project.team.id).listen('NewCommentPosted', function(e) {
        let $container = $('.comments-container');
        if ($container.length) {
            axios.get($container.data('get-comment-url'), {params: {id: e.comment.id}})
                 .then(function(response) {
                    $container.append(response.data);
                 });
        } else {
            alertUnreadComments();
        }
    });
}
</script>
        @stack('scripts')
    </body>
</html>
