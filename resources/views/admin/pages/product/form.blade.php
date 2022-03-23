<?php

    $ids = $product->categories->pluck("id")->toArray();

    //dd($ids);


$traverse = function ($categories, $prefix = '-') use (&$traverse,$ids) {

    $html = '<ul style="margin: initial !important;padding: initial !important;">';
    foreach ($categories as $category) {
        if(in_array($category->id,$ids)) $checked = 'checked';
        else $checked = '';
        $html .= '<li><label class="custom-control-label mt-1">
                        <input type="checkbox" name="categories[]" data-checkboxes="mygroup" class="custom-control-input" '. $checked .' id="'.$category->id.'" value="'.$category->id.'">
                        <span>'.$category->title.'</span>

                        </label></li>';


        if(count($category->children)){
            $html .= '<li style="padding-left: 20px">';
            $html .= $traverse($category->children, $prefix.'-');
            $html .= '</li>';
        }

    }

    $html .= '</ul>';

    return $html;
};

?>
{{-- extend layout --}}
@extends('admin.layout.contentLayoutMaster')
{{-- page title --}}
@section('title', $product->category_id ? __('admin.product-update') : 'admin.product-create')

@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection
{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/form-select2.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="col s12 m12 12">
            <div id="basic-form" class="card card card-default scrollspy">
                <div class="card-content">
                    <input name="old-images[]" id="old_images" hidden disabled value="{{$product->files}}">
                    <h4 class="card-title">{{$product->category_id ? __('admin.product-update') : __('admin.product-create')}}</h4>
                    {!! Form::model($product,['url' => $url, 'method' => $method,'files' => true]) !!}
                    <div class="row">
                        <div class="col s12 m6 8">
                            <div class="row">
                                <ul class="tabs">
                                    @foreach(config('translatable.locales') as $locale)
                                        <li class="tab col ">
                                            <a href="#lang-{{$locale}}">{{$locale}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                @foreach(config('translatable.locales') as $locale)
                                    <div id="lang-{{$locale}}" class="col s12  mt-5">
                                        <div class="input-field ">
                                            {!! Form::text($locale.'[title]',$product->translate($locale)->title ?? '',['class' => 'validate '. $errors->has($locale.'.title') ? '' : 'valid']) !!}
                                            {!! Form::label($locale.'[title]',__('admin.title')) !!}
                                            @error($locale.'.title')
                                            <small class="errorTxt4">
                                                <div class="error">
                                                    {{$message}}
                                                </div>
                                            </small>
                                            @enderror
                                        </div>
                                        <div class="input-field ">
                                            {!! Form::text($locale.'[short_description]',$product->translate($locale)->short_description ?? '',['class' => 'validate '. $errors->has($locale.'.short_description') ? '' : 'valid']) !!}
                                            {!! Form::label($locale.'[short_description]',__('admin.short_description')) !!}
                                            @error($locale.'.short_description')
                                            <small class="errorTxt4">
                                                <div class="error">
                                                    {{$message}}
                                                </div>
                                            </small>
                                            @enderror
                                        </div>
                                        <div class="input-field ">
                                            {!! Form::text($locale.'[meta_title]',$product->translate($locale)->meta_title ?? '',['class' => 'validate '. $errors->has($locale.'.meta_title') ? '' : 'valid']) !!}
                                            {!! Form::label($locale.'[meta_title]',__('admin.meta_title')) !!}
                                            @error($locale.'.meta_title')
                                            <small class="errorTxt4">
                                                <div class="error">
                                                    {{$message}}
                                                </div>
                                            </small>
                                            @enderror
                                        </div>
                                        <div class="input-field ">
                                            {!! Form::text($locale.'[meta_description]',$product->translate($locale)->meta_keyword ?? '',['class' => 'validate '. $errors->has($locale.'.meta_description') ? '' : 'valid']) !!}
                                            {!! Form::label($locale.'[meta_description]',__('admin.meta_description')) !!}
                                            @error($locale.'.meta_description')
                                            <small class="errorTxt4">
                                                <div class="error">
                                                    {{$message}}
                                                </div>
                                            </small>
                                            @enderror
                                        </div>
                                        <div class="input-field ">
                                            {!! Form::text($locale.'[meta_keyword]',$product->translate($locale)->meta_description ?? '',['class' => 'validate '. $errors->has($locale.'.meta_keyword') ? '' : 'valid']) !!}
                                            {!! Form::label($locale.'[meta_keyword]',__('admin.meta_keyword')) !!}
                                            @error($locale.'.meta_keyword')
                                            <small class="errorTxt4">
                                                <div class="error">
                                                    {{$message}}
                                                </div>
                                            </small>
                                            @enderror
                                        </div>


                                        <div class="input-field">
                                            <h5 for="description">@lang('admin.description')</h5>
                                            <textarea class="form-control" id="description-{{$locale}}"
                                                      name="{{$locale}}[description]'">
                                                {!! $product->translate($locale)->description ?? '' !!}
                                            </textarea>
                                            @error($locale.'.description')
                                            <small class="errorTxt4">
                                                <div class="error">
                                                    {{$message}}
                                                </div>
                                            </small>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col s12 m6 8">
                            <div class="row">
                                <div class="input-field col s12">
                                    {!! Form::text('slug',$product->slug,['class' => 'validate '. $errors->has('slug') ? '' : 'valid']) !!}
                                    {!! Form::label('slug',__('admin.slug')) !!}
                                    @error('slug')
                                    <small class="errorTxt4">
                                        <div class="error">
                                            {{$message}}
                                        </div>
                                    </small>
                                    @enderror
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::text('code',$product->code,['class' => 'validate '. $errors->has('code') ? '' : 'valid']) !!}
                                    {!! Form::label('code',__('admin.code')) !!}
                                    @error('code')
                                    <small class="errorTxt4">
                                        <div class="error">
                                            {{$message}}
                                        </div>
                                    </small>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="category_id">{{__('admin.category')}}</label>
                                </div>
                                <div class="input-field col s12">
                                    <?=$traverse($categories);?>

                                    @error('category_id')
                                    <small class="errorTxt4">
                                        <div class="error">
                                            {{$message}}
                                        </div>
                                    </small>
                                    @enderror
                                </div>
                                <div class="input-field"></div>
                                <div class="col s12 mt-3 mb-3">
                                    <label>
                                        <input type="checkbox" name="status"
                                               value="true" {{$product->status ? 'checked' : ''}}>
                                        <span>{{__('admin.status')}}</span>
                                    </label>
                                </div>

                                <div class="col s12 mt-3 mb-3">
                                    <label>
                                        <input type="checkbox" name="popular"
                                               value="true" {{$product->popular ? 'checked' : ''}}>
                                        <span>{{__('admin.popular')}}</span>
                                    </label>
                                </div>

                                <div class="col s12 mt-3 mb-3">
                                    <label>
                                        <input type="checkbox" name="stock"
                                               value="true" {{$product->stock ? 'checked' : ''}}>
                                        <span>{{__('admin.instock')}}</span>
                                    </label>
                                </div>

                                <div class="col s12 mt-3 mb-3">
                                    <div class="input-field ">
                                        {!! Form::number('sale',$product->sale ?? '',['step'=>'0.1']) !!}
                                        {!! Form::label('sale',__('admin.sale')) !!}
                                        @error('sale')
                                        <small class="errorTxt4">
                                            <div class="error">
                                                {{$message}}
                                            </div>
                                        </small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="input-images"></div>
                                @if ($errors->has('images'))
                                    <span class="help-block">
                                            {{ $errors->first('images') }}
                                        </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            {!! Form::submit($product->created_at ? __('admin.update') : __('admin.create'),['class' => 'btn cyan waves-effect waves-light ']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}


                </div>
            </div>
        </div>
    </div>

@endsection

{{-- vendor script --}}
@section('vendor-script')
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        @foreach(config('translatable.locales') as $locale)
        CKEDITOR.replace('description-{{$locale}}', {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        @endforeach
    </script>
@endsection


