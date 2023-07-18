@extends('layouts.backend-settings')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
    
    
        <form action="{{route('settings.theme')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Website Name</label>
                <div class="col-lg-9">
                    <input name="site_name" class="form-control" value="{{$settings->site_name}}" type="text">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Light Logo</label>
                <div class="col-lg-7">
                    <input type="file" class="form-control" name="logo">
                    <span class="form-text text-muted">Recommended image size is 40px x 40px</span>
                </div>
                <div class="col-lg-2">
                    <div class="img-thumbnail float-end"><img src="{{!empty($settings->logo) ? asset('storage/settings/theme/'.$settings->logo): asset('assets/img/logo2.png')}}" alt="logo" width="40" height="40"></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Favicon</label>
                <div class="col-lg-7">
                    <input type="file" name="favicon" class="form-control">
                    <span class="form-text text-muted">Recommended image size is 16px x 16px</span>
                </div>
                <div class="col-lg-2">
                    <div class="settings-image img-thumbnail float-end"><img src="{{ !empty($settings->favicon) ? asset('storage/settings/theme/'.$settings->favicon):asset('assets/img/logo2.png') }}" class="img-fluid" width="16" height="16" alt="favicon"></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-6">
                    <label class="form-label">Currency Code</label>
                    <input type="text" name="currency_code" value="{{$settings->currency_code}}" class="form-control">
                </div>
                <div class="col-6">
                    <label class="form-label">Currency Symbol</label>
                    <input type="text" name="currency_symbol" value="{{$settings->currency_symbol}}" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label class="form-label">Theme Color</label>
                </div>
                <div class="col">
                    <label><input class="form-check-input" type="radio" name="theme_color" value="dark" id="theme_color_dark" {{!empty($settings->theme_color) && $settings->theme_color == "dark" ? 'checked' : ''}}>Dark</label>
                </div>
                <div class="col">
                    <label><input class="form-check-input" type="radio" name="theme_color" value="light" id="theme_color_light" {{!empty($settings->theme_color) && $settings->theme_color == "light" ? 'checked' : ''}}>Light</label>
                </div>
                <div class="col">
                    <label><input class="form-check-input" type="radio" name="theme_color" value="maroon" id="theme_color_maroon" {{!empty($settings->theme_color) && $settings->theme_color == "maroon" ? 'checked' : ''}}>Maroon</label>
                </div>
                <div class="col">
                    <label><input class="form-check-input" type="radio" name="theme_color" value="purple" id="theme_color_purple" {{!empty($settings->theme_color) && $settings->theme_color == "purple" ? 'checked' : ''}}>Purple</label>
                </div>
                <div class="col">
                    <label><input class="form-check-input" type="radio" name="theme_color" value="blue" id="theme_color_blue" {{!empty($settings->theme_color) && $settings->theme_color == "blue" ? 'checked' : ''}}>Blue</label>
                </div>
            </div>
            <div class="submit-section">
                <button type="submit" class="btn btn-primary submit-btn">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection


