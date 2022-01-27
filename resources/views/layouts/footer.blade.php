<footer class="container-fluid bg-primary">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <img src="{{asset('images/logo_white.png')}}" class="logo mb-2">
                <div class="mb-2">Hoist Industries was established to provide consulting and managing services. We also have a division that provides service, repair, parts and conversions for construction elevators.</div>
                <div class="d-flex">
                    <a href="{{config('services.social.twitter')}}" target="_blank" class="mr-2">@fa(['fa_type' => 'b', 'icon' => 'twitter', 'size' => 'lg'])</a>
                    <a href="{{config('services.social.linkedin')}}" target="_blank" class="mr-2">@fa(['fa_type' => 'b', 'icon' => 'linkedin', 'size' => 'lg'])</a>
                    <a href="mailto:{{config('brand.emails.info')}}">@fa(['icon' => 'envelope', 'size' => 'lg'])</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row py-3" style="border-top: 1px solid rgba(255,255,255,0.12)">
            <div class="col-12 d-flex d-apart flex-wrap">
                <div>© {{now()->year}} | All rights reserved - {{config('app.name')}}, Inc.</div>
                <div><a href="" class="">Privacy Policy</a></div>
            </div>
        </div>
    </div>
</footer>