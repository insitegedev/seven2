@extends('admin.nowa.views.layouts.app')

@section('styles')



@endsection

@section('content')



    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">@lang('admin.translations')</span>
        </div>
        <div class="justify-content-center mt-2">
            @include('admin.nowa.views.layouts.components.breadcrump')
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@lang('admin.translations')</h4>
                    </div>


                    {{--<p class="tx-12 tx-gray-500 mb-2">Example of Nowa Simple Table. <a href="">Learn more</a></p>--}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form class="mr-0 p-0">
                            <table class="table mg-b-0 text-md-nowrap">
                                <thead>
                                <tr>
                                    <th>@lang('admin.id')</th>
                                    <th>@lang('admin.group')</th>
                                    <th>@lang('admin.key')</th>
                                    <th>@lang('admin.text')</th>
                                    <th>@lang('admin.actions')</th>
                                </thead>
                                <tbody>

                                <tr>
                                    <th>
                                        <input class="form-control" type="number" name="id" onchange="this.form.submit()"
                                               value="{{Request::get('id')}}"
                                               class="validate {{$errors->has('id') ? '' : 'valid'}}">
                                    </th>
                                    <th>
                                        <input class="form-control" type="text" name="group" onchange="this.form.submit()"
                                               value="{{Request::get('group')}}"
                                               class="validate {{$errors->has('group') ? '' : 'valid'}}">
                                    </th>
                                    <th>
                                        <input class="form-control" type="text" name="key" onchange="this.form.submit()"
                                               value="{{Request::get('key')}}"
                                               class="validate {{$errors->has('key') ? '' : 'valid'}}">
                                    </th>
                                    <th>
                                        <input class="form-control" type="text" name="text" onchange="this.form.submit()"
                                               value="{{Request::get('text')}}"
                                               class="validate {{$errors->has('text') ? '' : 'valid'}}">
                                    </th>
                                    <th></th>


                                @if($translations)
                                    @foreach($translations as $translation)
                                        <tr>
                                            <td>{{$translation->id}}</td>
                                            <td>{{$translation->group}}</td>
                                            <td>{{$translation->key}}</td>
                                            <td>



                                                    <div class="panel panel-primary tabs-style-2">
                                                        <div class=" tab-menu-heading">
                                                            <div class="tabs-menu1">
                                                                <!-- Tabs -->
                                                                <ul class="nav panel-tabs main-nav-line">
                                                                    @foreach($translation->text as $key => $text)
                                                                        @if(isset($languages[$key]))
                                                                        <li><a href="#cat-{{$translation->id}}-{{$key}}" class="nav-link {{$loop->first?"active":""}}" data-bs-toggle="tab">{{$languages[$key]->locale}}</a></li>
                                                                        @endif
                                                                    @endforeach

                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="panel-body tabs-menu-body main-content-body-right border">
                                                            <div class="tab-content">

                                                                @foreach($translation->text as $key => $text)
                                                                    @if(isset($languages[$key]))
                                                                    <div class="tab-pane {{$loop->first?"active":""}}" id="cat-{{$translation->id}}-{{$key}}">
                                                                        {{$text}}
                                                                    </div>
                                                                    @endif
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>

                                            </td>
                                            <td>

                                                <a href="{{locale_route('translation.edit',$translation->id)}}"
                                                   class="pl-3">
                                                    <i class="fa fa-edit">edit</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif


                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
        <div class="col-xl-12">
        {{ $translations->appends(request()->input())->links('admin.vendor.pagination.material') }}
        </div>
    </div>
    <!-- /row -->

@endsection

@section('scripts')



@endsection
