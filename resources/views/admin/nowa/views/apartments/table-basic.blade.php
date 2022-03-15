@extends('admin.nowa.views.layouts.app')

    @section('styles')



    @endsection

    @section('content')



					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
						  <span class="main-content-title mg-b-0 mg-b-lg-1">@lang('admin.apartment')</span>
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
										<h4 class="card-title mg-b-0">@lang('admin.apartment')</h4>
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
													<th>@lang('admin.title')</th>
													<th>@lang('admin.floor')</th>
													<th>@lang('admin.apartments')</th>
                                                    <th>@lang('admin.actions')</th>
												</tr>
											</thead>
											<tbody>

                                            <tr>
                                                <th>
                                                    <input class="form-control" type="number" name="id" onchange="this.form.submit()"
                                                           value="{{Request::get('id')}}"
                                                           class="validate {{$errors->has('id') ? '' : 'valid'}}">
                                                </th>
                                                <th>
                                                    <input class="form-control" type="text" name="title" onchange="this.form.submit()"
                                                           value="{{Request::get('title')}}"
                                                           class="validate {{$errors->has('title') ? '' : 'valid'}}">
                                                </th>
                                                <th>
                                                    <input class="form-control" type="text" name="floor" onchange="this.form.submit()"
                                                           value="{{Request::get('floor')}}"
                                                           class="validate {{$errors->has('floor') ? '' : 'valid'}}">
                                                </th>
                                                <th>
                                                    <input class="form-control" type="text" name="apartments" onchange="this.form.submit()"
                                                           value="{{Request::get('apartments')}}"
                                                           class="validate {{$errors->has('apartments') ? '' : 'valid'}}">
                                                </th>

                                            @if($apartments)
                                                @foreach($apartments as $apartment)
                                                    <tr>
                                                        <th scope="row">{{$apartment->id}}</th>
                                                        <td>{{$apartment->title}}</td>
                                                        <td>

                                                                    @include('admin.nowa.views.layouts.components.tabs')

                                                        </td>
                                                        <td>

                                                            <div class="panel panel-primary tabs-style-2">
                                                                <div class=" tab-menu-heading">
                                                                    <div class="tabs-menu1">
                                                                        <!-- Tabs -->
                                                                        <ul class="nav panel-tabs main-nav-line">
                                                                            @foreach(config('translatable.locales') as $locale)
                                                                                <?php
                                                                                $active = '';
                                                                                if($loop->first) $active = 'active';
                                                                                ?>

                                                                                <li><a href="#apartments-{{$locale}}-{{$apartment->id}}" class="nav-link {{$active}}" data-bs-toggle="tab">{{$locale}}</a></li>
                                                                            @endforeach

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                                                    <div class="tab-content">

                                                                        @foreach(config('translatable.locales') as $locale)

                                                                            <?php
                                                                            $active = '';
                                                                            if($loop->first) $active = 'active';
                                                                            ?>
                                                                            <div class="tab-pane {{$active}}" id="apartments-{{$locale}}-{{$apartment->id}}">
                                                                                {{$apartment->translate($locale)->apartments ?? ''}}
                                                                            </div>
                                                                        @endforeach

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="{{locale_route('apartment.show',$apartment->id)}}">
                                                                <i class="material-icons">remove_red_eye</i>
                                                            </a>
                                                            <a href="{{locale_route('apartment.edit',$apartment->id)}}"
                                                               class="pl-3">
                                                                <i class="material-icons">edit</i>
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

                        {{ $apartments->appends(request()->input())->links('admin.vendor.pagination.material') }}
					</div>
					<!-- /row -->

    @endsection

    @section('scripts')



    @endsection
