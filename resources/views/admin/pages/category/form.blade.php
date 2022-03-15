{{-- extend layout --}}
@extends('admin.layout.contentLayoutMaster')
{{-- page title --}}
@section('title', $category->created_at ? __('admin.category-update') : 'admin.category-create')

@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/dropify/css/dropify.min.css')}}">
@endsection
{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/form-select2.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="col s12 m6 l6">
            <div id="basic-form" class="card card card-default scrollspy">
                <div class="card-content">
                    <h4 class="card-title">{{$category->created_at ? __('admin.category-update') : __('admin.category-create')}}</h4>
                    {!! Form::model($category,['url' => $url, 'method' => $method,'files' => true]) !!}
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
                                <div class="input-field">
                                    {!! Form::text($locale.'[title]',$category->translate($locale)->title ?? '',['class' => 'validate '. $errors->has($locale.'[title]') ? '' : 'valid']) !!}
                                    {!! Form::label($locale.'[title]',__('admin.title')) !!}
                                    @error($locale.'.title')
                                    <small class="errorTxt4">
                                        <div class="error">
                                            {{$message}}
                                        </div>
                                    </small>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                        <div class="col s12 mt-2">
                            <label>
                                <input type="checkbox" name="status"
                                       value="true" {{$category->status ? 'checked' : ''}}>
                                <span>@lang('admin.status')</span>
                            </label>
                        </div>

                        <div class="col s12 mt-2">
                            <input id="parent" type="hidden" name="parent_id" value="{{$category->parent_id}}">
                            <div class="control-container">
                                <div class="controls-group">
                                    <label>parent<input id="inp_parent" type="text" name="path" value="{!! $category->path !!}"></label>

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            {!! Form::submit($category->created_at ? __('admin.update') : __('admin.create'),['class' => 'btn cyan waves-effect waves-light right']) !!}
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
    <script src="{{asset('vendors/dropify/js/dropify.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{asset('js/scripts/form-select2.js')}}"></script>
    <script src="{{asset('js/scripts/form-file-uploads.js')}}"></script>
    <script>

        // Autocomplete */
        (function($) {
            $.fn.autocomplete = function(option) {
                return this.each(function() {
                    var $this = $(this);
                    var $dropdown = $('<ul class="dropdown-menu" />');

                    this.timer = null;
                    this.items = [];

                    $.extend(this, option);

                    $this.attr('autocomplete', 'off');

                    // Focus
                    $this.on('focus', function() {
                        this.request();
                    });

                    // Blur
                    $this.on('blur', function() {
                        setTimeout(function(object) {
                            object.hide();
                        }, 200, this);
                    });

                    // Keydown
                    $this.on('keydown', function(event) {
                        switch(event.keyCode) {
                            case 27: // escape
                                this.hide();
                                break;
                            default:
                                this.request();
                                break;
                        }
                    });

                    // Click
                    this.click = function(event) {
                        event.preventDefault();

                        var value = $(event.target).parent().attr('data-value');

                        if (value && this.items[value]) {
                            this.select(this.items[value]);
                        }
                    }

                    // Show
                    this.show = function() {
                        var pos = $this.position();

                        $dropdown.css({
                            top: pos.top + $this.outerHeight(),
                            left: pos.left
                        });

                        $dropdown.show();
                    }

                    // Hide
                    this.hide = function() {
                        $dropdown.hide();
                    }

                    // Request
                    this.request = function() {
                        clearTimeout(this.timer);

                        this.timer = setTimeout(function(object) {
                            object.source($(object).val(), $.proxy(object.response, object));
                        }, 200, this);
                    }

                    // Response
                    this.response = function(json) {
                        var html = '';
                        var category = {};
                        var name;
                        var i = 0, j = 0;

                        if (json.length) {
                            for (i = 0; i < json.length; i++) {
                                // update element items
                                this.items[json[i]['value']] = json[i];

                                if (!json[i]['category']) {
                                    // ungrouped items
                                    html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
                                } else {
                                    // grouped items
                                    name = json[i]['category'];
                                    if (!category[name]) {
                                        category[name] = [];
                                    }

                                    category[name].push(json[i]);
                                }
                            }

                            for (name in category) {
                                html += '<li class="dropdown-header">' + name + '</li>';

                                for (j = 0; j < category[name].length; j++) {
                                    html += '<li data-value="' + category[name][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[name][j]['label'] + '</a></li>';
                                }
                            }
                        }

                        if (html) {
                            this.show();
                        } else {
                            this.hide();
                        }

                        $dropdown.html(html);
                    }

                    $dropdown.on('click', '> li > a', $.proxy(this.click, this));
                    $this.after($dropdown);
                });
            }
        })(window.jQuery);


        $(document).ready(function(){
            $('#inp_parent').click(function(){

            });

            $('[data-value]  a').click(function(e){
                e.preventDefault();
            });

            $('[data-value]').click(function(){
                alert('dd');
                $('#parent').val($(this).data('value'));
                $('#inp_parent').val($(this).text());
            });
        });

        $('input[name=\'path\']').autocomplete({
            'source': function(request, response) {
                $.ajax({
                    url: '{{route('autocomplete')}}',
                    data: { filter_name: encodeURIComponent(request) },
                    dataType: 'json',
                    success: function(json) {
                        json.unshift({
                            category_id: 0,
                            name: '-- NONE --'
                        });

                        response($.map(json, function(item) {
                            return {
                                label: item['name'],
                                value: item['category_id']
                            }
                        }));
                    }
                });
            },
            'select': function(item) {
                $('input[name=\'path\']').val(item['label']);
                $('input[name=\'parent_id\']').val(item['value']);
            }
        });
    </script>
@endsection
