@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'Manage Section',
            'directory'=>'cms',
            'back'=>'home',
        ])
        <div class="container-fluid">
            <div class="card card-custom">
                <form method="POST" action="{{ route('manage-section.store') }}" class="ajax-form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <ul class="nav nav-pills" id="myTab" role="tablist">
                            @if(!empty($manageSection))
                                @foreach($manageSection as $section)
                                    @php
                                        $tab = strtolower(str_replace(' ', '-', $section['label']));
                                    @endphp
                                    <li class="nav-item">
                                        <a class="nav-link {{ $loop->first ? 'active' : '' }} " id="{{ $tab }}-tab"
                                           data-toggle="tab" href="#{{$tab}}">
                                            <span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
                                            <span
                                                class="nav-text">{{!empty($section['label'])?$section['label']:''}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent3">
                            @foreach ($manageSection as $section)
                                @php
                                    $tab = strtolower(str_replace(' ', '-', $section['label']));
                                @endphp
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tab }}"
                                     role="tabpanel" aria-labelledby="{{ $tab }}-tab">
                                    <div class="row">
                                        @foreach ($section['fields'] as $inputName => $configInput)
                                            @include('include.manage-section.input')
                                        @endforeach
                                        <div class="card-footer">
                                            <div class="row">
                                                <button id="form_submit" class="btn btn-primary mr-2"><i
                                                        class="fas fa-save"></i>Save
                                                </button>
                                                <button type="reset" class="btn btn-danger"><i
                                                        class="fas fa-times"></i>Reset
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>

        $('.summernote').summernote({
            height: 150
        });

        @if (!empty($AJAX_PATH))
        var ajaxTable = $('#manage-section-table').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            stateSave: true,
            pagingType: "full_numbers",
            ajax: "{{url(!empty($AJAX_PATH)?$AJAX_PATH:'/')}}",
            lengthMenu: [[10, 25, 50, 100, 500, 1000000], [10, 25, 50, 100, 500, "All"]],
            columns: [
                {
                    data: 'pages',
                    name: 'pages',
                },
                {
                    data: 'action',
                    name: 'action',
                },

            ]
        });
        @endif
    </script>

@endpush



