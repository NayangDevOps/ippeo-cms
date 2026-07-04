@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Site Settings</h2>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">General Settings</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Site Name</label>
                        <input type="text" class="form-control" name="settings[site_name]" 
                               value="{{ $settings['site_name'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Site Tagline</label>
                        <input type="text" class="form-control" name="settings[site_tagline]" 
                               value="{{ $settings['site_tagline'] ?? '' }}">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Site Description</label>
                <textarea class="form-control" name="settings[site_description]" rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Site Logo</label>
                        @if(isset($settings['site_logo']))
                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" class="img-thumbnail d-block mb-2" style="max-height: 100px;">
                        @endif
                        <input type="file" class="form-control" name="settings[site_logo]" accept="image/*">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Site Favicon</label>
                        @if(isset($settings['site_favicon']))
                            <img src="{{ asset('storage/' . $settings['site_favicon']) }}" class="img-thumbnail d-block mb-2" style="max-height: 50px;">
                        @endif
                        <input type="file" class="form-control" name="settings[site_favicon]" accept="image/*">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Contact Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Contact Email</label>
                        <input type="email" class="form-control" name="settings[contact_email]" 
                               value="{{ $settings['contact_email'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" class="form-control" name="settings[contact_phone]" 
                               value="{{ $settings['contact_phone'] ?? '' }}">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control" name="settings[contact_address]" rows="2">{{ $settings['contact_address'] ?? '' }}</textarea>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Social Media Links</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Facebook URL</label>
                        <input type="url" class="form-control" name="settings[facebook_url]" 
                               value="{{ $settings['facebook_url'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Instagram URL</label>
                        <input type="url" class="form-control" name="settings[instagram_url]" 
                               value="{{ $settings['instagram_url'] ?? '' }}">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Twitter URL</label>
                        <input type="url" class="form-control" name="settings[twitter_url]" 
                               value="{{ $settings['twitter_url'] ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Pinterest URL</label>
                        <input type="url" class="form-control" name="settings[pinterest_url]" 
                               value="{{ $settings['pinterest_url'] ?? '' }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">SEO Settings</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Meta Title</label>
                <input type="text" class="form-control" name="settings[meta_title]" 
                       value="{{ $settings['meta_title'] ?? '' }}">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Meta Description</label>
                <textarea class="form-control" name="settings[meta_description]" rows="3">{{ $settings['meta_description'] ?? '' }}</textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Meta Keywords</label>
                <input type="text" class="form-control" name="settings[meta_keywords]" 
                       value="{{ $settings['meta_keywords'] ?? '' }}">
                <small class="text-muted">Separate keywords with commas</small>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-save me-2"></i>Save Settings
            </button>
        </div>
    </div>
</form>
@endsection
