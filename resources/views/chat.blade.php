<?php $page = 'chat'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">
        
        <!-- Start Content -->
        <div class="content">

            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
                <div>
                    <h4 class="mb-1">Chat</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Applications</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Chat</li>
                        </ol>
                    </nav>
                </div>
                <div class="gap-2 d-flex align-items-center flex-wrap">
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Collapse" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-transition-top"></i></a>
                </div>
            </div>                
            <!-- End Page Header -->

            <div class="chat-wrapper">

                <div class="card shadow-none mb-0">
                    <div class="card-body p-0">

                        <div class="d-lg-flex">
                            <div class="chat-user-nav">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between border-bottom p-3">
                                        <div class="d-flex align-items-center">
                                            <span class="avatar me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-2.jpg')}}" class="rounded-circle" alt="user"></span>
                                            <div>
                                                <h6 class="fs-14 mb-1">James Hong </h6>
                                                <p class="mb-0">Admin</p>
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="New Chat"><i class="ti ti-plus"></i></a>
                                    </div>
                                    <div>
                                        <div class="input-group w-auto input-group-flat p-4 pb-0">
                                            <span class="input-group-text border-end-0"><i class="ti ti-search"></i></span>
                                            <input type="text" class="form-control" placeholder="Search Keyword">
                                        </div>
                                        <div class="chat-users p-4" data-simplebar>
                                            <h6 class="mb-3">All Messages</h6>
                                            <div class="d-flex align-items-center justify-content-between rounded p-3 user-list active mb-1">
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="avatar me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-5.jpg')}}" class="rounded-circle" alt="user"></a>
                                                    <div>
                                                        <h6 class="fs-14 mb-1"><a href="#">Mark Smith</a></h6>
                                                        <p class="mb-0 text-truncate">Hey Sam! Did you Ch...</p>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-dark d-block">10:10 AM</span>
                                                    <span class="d-block text-success"><i class="ti ti-checks"></i></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between rounded p-3 user-list mb-1">
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="avatar me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-4.jpg')}}" class="rounded-circle" alt="user"></a>
                                                    <div>
                                                        <h6 class="fs-14 mb-1"><a href="#">Eugene Sikora</a></h6>
                                                        <p class="mb-0 text-truncate">How are your Today</p>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-dark d-block mb-1">08:26 AM</span>
                                                    <span class="badge ms-auto bg-danger rounded-circle message-count">5</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between rounded p-3 user-list mb-1">
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="avatar me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/user-08.jpg')}}" class="rounded-circle" alt="user"></a>
                                                    <div>
                                                        <h6 class="fs-14 mb-1"><a href="#">Robert Fassett</a></h6>
                                                        <p class="mb-0 text-truncate">Here are some of ve...</p>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-dark d-block mb-1">yesterday</span>
                                                    <span class="badge ms-auto bg-danger rounded-circle message-count">5</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between rounded p-3 user-list mb-1">
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="avatar me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/user-04.jpg')}}" class="rounded-circle" alt="user"></a>
                                                    <div>
                                                        <h6 class="fs-14 mb-1"><a href="#">Andrew Fletcher</a></h6>
                                                        <p class="mb-0 text-truncate">Use tools like Trello...</p>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-dark d-block mb-1">yesterday</span>
                                                    <span class="d-block text-light"><i class="ti ti-checks"></i></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between rounded p-3 user-list mb-1">
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="avatar badge-soft-purple fw-semibold me-2 flex-shrink-0">TD</a>
                                                    <div>
                                                        <h6 class="fs-14 mb-1"><a href="#">Tyron Derby</a></h6>
                                                        <p class="mb-0 text-truncate">Let's reconvene next...</p>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-dark d-block mb-1">12:55 PM</span>
                                                    <span class="d-block text-light"><i class="ti ti-checks text-success"></i></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between rounded p-3 user-list mb-1">
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="avatar me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-6.jpg')}}" class="rounded-circle" alt="user"></a>
                                                    <div>
                                                        <h6 class="fs-14 mb-1"><a href="#">Anna Johnson</a></h6>
                                                        <p class="mb-0 text-truncate">How are your Today</p>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-dark d-block mb-1">12:54 PM</span>
                                                    <span class="d-block text-light"><i class="ti ti-check text-light"></i></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between rounded p-3 user-list mb-1">
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="avatar me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-8.jpg')}}" class="rounded-circle" alt="user"></a>
                                                    <div>
                                                        <h6 class="fs-14 mb-1"><a href="#">Emily Davis</a></h6>
                                                        <p class="mb-0 text-truncate">Sure, I can help with...</p>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-dark d-block mb-1">11:47 PM</span>
                                                    <span class="d-block text-light"><i class="ti ti-checks text-light"></i></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between rounded p-3 user-list mb-1">
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="avatar me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/user-06.jpg')}}" class="rounded-circle" alt="user"></a>
                                                    <div>
                                                        <h6 class="fs-14 mb-1"><a href="#">Susan Denton</a></h6>
                                                        <p class="mb-0 text-truncate">I'll share the meeting...</p>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-dark d-block mb-1">10:43 PM</span>
                                                    <span class="d-block text-light"><i class="ti ti-checks text-light"></i></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between rounded p-3 user-list">
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="avatar me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-9.jpg')}}" class="rounded-circle" alt="user"></a>
                                                    <div>
                                                        <h6 class="fs-14 mb-1"><a href="#">David Cruz</a></h6>
                                                        <p class="mb-0 text-truncate">Let me know if you...</p>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-dark d-block mb-1">10:43 PM</span>
                                                    <span class="d-block text-light"><i class="ti ti-checks text-light"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- end card body -->
                            </div>
                            <div class="flex-fill chat-messages">
                                <!-- card start -->
                                <div class="card border-0 mb-0">

                                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3 p-3">
                                        <div class="d-flex align-items-center">
                                            <span class="avatar me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-5.jpg')}}" alt="user" class="rounded-circle"></span>
                                            <div>
                                                <h6 class="fs-14 fw-semibold mb-1">Mark Smith</h6>
                                                <p class="mb-0 d-inline-flex align-items-center custom-dot"><i class="ti ti-point-filled text-success"></i>Online</p>
                                            </div>
                                        </div>
                                        <div class="gap-2 d-flex align-items-center flex-wrap">
                                            <a href="{{url('audio-call')}}" class="btn btn-icon btn-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Voice Call"><i class="ti ti-phone"></i></a>
                                            <a href="{{url('video-call')}}" class="btn btn-icon btn-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Video Call"><i class="ti ti-video"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-icon btn-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Info"><i class="ti ti-info-circle"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-icon btn-light close-chat d-md-none"><i class="ti ti-x"></i></a>
                                        </div>
                                    </div>

                                    <div class="card-body p-0">
                                        <div class="message-body p-4" data-simplebar>
                                            <div class="chat-list mb-3">
                                                <div class="d-flex align-items-start">
                                                    <span class="avatar online me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-5.jpg')}}" class="rounded-circle" alt="user"></span>
                                                    <div>
                                                        <div class="d-flex align-items-center mb-1">
                                                            <h6 class="fs-14 mb-0">Mark Smith</h6>
                                                            <p class="mb-0 d-inline-flex align-items-center"><i class="ti ti-point-filled mx-2"></i>02:39 PM</p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="message-box receive-message p-3">
                                                                <p class="mb-0 fs-14">Hey mark! Did you check out the new logo design?</p>
                                                            </div>
                                                            <div class="ms-2">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                                <ul class="dropdown-menu p-2">
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-back-up me-1"></i>Reply</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-forward-up me-1"></i>Forward</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-file-export me-1"></i>Copy</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-heart me-1"></i>Mark as Favourite</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-trash me-1"></i>Delete</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-check me-1"></i>Mark as Unread</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-box-align-right me-1"></i>Archeive Chat</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-pinned me-1"></i>Pin Chat</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="chat-list ms-auto mb-3">
                                                <div class="d-flex align-items-start justify-content-end">
                                                    <div>
                                                        <div class="d-flex align-items-center justify-content-end mb-1">
                                                            <p class="mb-0 d-inline-flex align-items-center"><i class="ti ti-checks text-success me-1"></i>02:39 PM<i class="ti ti-point-filled mx-2"></i></p>
                                                            <h6 class="fs-14 fw-semibold mb-0">You</h6>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-2">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                                <ul class="dropdown-menu p-2">
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-back-up me-1"></i>Reply</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-forward-up me-1"></i>Forward</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-file-export me-1"></i>Copy</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-heart me-1"></i>Mark as Favourite</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-trash me-1"></i>Delete</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-check me-1"></i>Mark as Unread</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-box-align-right me-1"></i>Archeive Chat</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-pinned me-1"></i>Pin Chat</a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="message-box sent-message p-3">
                                                                <p class="mb-0 fs-14">Not yet. Can you send it here?</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="avatar ms-2 online flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-2.jpg')}}" class="rounded-circle" alt="user"></span>
                                                </div>
                                            </div>
                                            <div class="chat-list mb-3">
                                                <div class="d-flex align-items-start">
                                                    <span class="avatar online me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-5.jpg')}}" class="rounded-circle" alt="user"></span>
                                                    <div>
                                                        <div class="d-flex align-items-center mb-1">
                                                            <h6 class="fs-14 mb-0">Mark Smith</h6>
                                                            <p class="mb-0 d-inline-flex align-items-center"><i class="ti ti-point-filled mx-2"></i>02:39 PM</p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="message-box receive-message p-3">
                                                                <p class="mb-2 fs-14">Sure! Please check the below logo Attached!!!</p>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <span class="bg-white d-block rounded p-1"><img src="{{URL::asset('/build/img/social/attachment-03.jpg')}}" class="rounded" alt="attachment"></span>
                                                                    <span class="bg-white d-block rounded p-1"><img src="{{URL::asset('/build/img/social/attachment-04.jpg')}}" class="rounded" alt="attachment"></span>
                                                                </div>
                                                            </div>
                                                            <div class="ms-2">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                                <ul class="dropdown-menu p-2">
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-back-up me-1"></i>Reply</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-forward-up me-1"></i>Forward</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-file-export me-1"></i>Copy</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-heart me-1"></i>Mark as Favourite</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-trash me-1"></i>Delete</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-check me-1"></i>Mark as Unread</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-box-align-right me-1"></i>Archeive Chat</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-pinned me-1"></i>Pin Chat</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center"><span class="badge bg-light rounded-pill px-3 text-dark fs-14">Today</span></div>
                                            <div class="chat-list ms-auto mb-3">
                                                <div class="d-flex align-items-start justify-content-end">
                                                    <div>
                                                        <div class="d-flex align-items-center justify-content-end mb-1">
                                                            <p class="mb-0 d-inline-flex align-items-center"><i class="ti ti-checks text-success me-1"></i>10:00 AM<i class="ti ti-point-filled mx-2"></i></p>
                                                            <h6 class="fs-14 fw-semibold mb-0">You</h6>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-2">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                                <ul class="dropdown-menu p-2">
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-back-up me-1"></i>Reply</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-forward-up me-1"></i>Forward</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-file-export me-1"></i>Copy</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-heart me-1"></i>Mark as Favourite</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-trash me-1"></i>Delete</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-check me-1"></i>Mark as Unread</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-box-align-right me-1"></i>Archeive Chat</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-pinned me-1"></i>Pin Chat</a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="message-box sent-message p-3">
                                                                <p class="mb-0 fs-14">Looks clean! I like the font. Maybe try a slightly darker blue?</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="avatar ms-2 online flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-2.jpg')}}" class="rounded-circle" alt="user"></span>
                                                </div>
                                            </div>
                                            <div class="chat-list mb-3">
                                                <div class="d-flex align-items-start">
                                                    <span class="avatar online me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-5.jpg')}}" class="rounded-circle" alt="user"></span>
                                                    <div>
                                                        <div class="d-flex align-items-center mb-1">
                                                            <h6 class="fs-14 mb-0">Mark Smith</h6>
                                                            <p class="mb-0 d-inline-flex align-items-center"><i class="ti ti-point-filled mx-2"></i>10:05 AM</p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="message-box receive-message p-3">
                                                                <p class="mb-0 fs-14">Perfect! That layout will work great on the landing page. 👍</p>
                                                            </div>
                                                            <div class="ms-2">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                                <ul class="dropdown-menu p-2">
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-back-up me-1"></i>Reply</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-forward-up me-1"></i>Forward</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-file-export me-1"></i>Copy</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-heart me-1"></i>Mark as Favourite</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-trash me-1"></i>Delete</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-check me-1"></i>Mark as Unread</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-box-align-right me-1"></i>Archeive Chat</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-pinned me-1"></i>Pin Chat</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="chat-list ms-auto mb-3">
                                                <div class="d-flex align-items-start justify-content-end">
                                                    <div>
                                                        <div class="d-flex align-items-center justify-content-end mb-1">
                                                            <p class="mb-0 d-inline-flex align-items-center"><i class="ti ti-checks text-success me-1"></i>10:00 AM<i class="ti ti-point-filled mx-2"></i></p>
                                                            <h6 class="fs-14 fw-semibold mb-0">You</h6>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-2">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                                <ul class="dropdown-menu p-2">
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-back-up me-1"></i>Reply</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-forward-up me-1"></i>Forward</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-file-export me-1"></i>Copy</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-heart me-1"></i>Mark as Favourite</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-trash me-1"></i>Delete</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-check me-1"></i>Mark as Unread</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-box-align-right me-1"></i>Archeive Chat</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-pinned me-1"></i>Pin Chat</a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="message-box sent-message p-3">
                                                                <p class="mb-0 fs-14">Perfect It looks Great!!!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="avatar ms-2 online flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-2.jpg')}}" class="rounded-circle" alt="user"></span>
                                                </div>
                                            </div>
                                            <div class="chat-list">
                                                <div class="d-flex align-items-start">
                                                    <span class="avatar online me-2 flex-shrink-0"><img src="{{URL::asset('/build/img/users/avatar-5.jpg')}}" class="rounded-circle" alt="user"></span>
                                                    <div>
                                                        <div class="d-flex align-items-center mb-1">
                                                            <h6 class="fs-14 mb-0">Mark Smith</h6>
                                                            <p class="mb-0 d-inline-flex align-items-center"><i class="ti ti-point-filled mx-2"></i>02:39 PM</p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="message-box receive-message p-3">
                                                                <p class="mb-0 fs-14">Hey mark! Did you check out the new logo design?</p>
                                                            </div>
                                                            <div class="ms-2">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                                <ul class="dropdown-menu p-2">
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-back-up me-1"></i>Reply</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-arrow-forward-up me-1"></i>Forward</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-file-export me-1"></i>Copy</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-heart me-1"></i>Mark as Favourite</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-trash me-1"></i>Delete</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-check me-1"></i>Mark as Unread</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-box-align-right me-1"></i>Archeive Chat</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-pinned me-1"></i>Pin Chat</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="message-footer d-flex align-items-center border-top p-3">
                                            <div class="flex-fill">
                                                <input type="text" class="form-control border-0" placeholder="Type Something...">
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="javascript:void(0);" class="btn btn-icon btn-light"><i class="ti ti-photo-plus"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-icon btn-light"><i class="ti ti-mood-smile-beam"></i></a>
                                                <div>
                                                    <a href="javascript:void(0);" class="btn btn-icon btn-light" data-bs-toggle="dropdown" aria-label="more options"><i class="ti ti-dots-vertical"></i></a>
                                                    <ul class="dropdown-menu p-2">
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="ti ti-camera-selfie me-2"></i>Camera</a>
                                                        </li>                                       
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="ti ti-photo-up me-2"></i>Gallery</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="ti ti-music me-2"></i>Audio</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="ti ti-map-pin-share me-2"></i>Location</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="ti ti-user-check me-2"></i>Contact</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a class="btn btn-icon btn-primary" href="javascript:void(0);" data-discover="true"><i class="ti ti-send"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- card start -->
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->

            </div>
                            
        </div>
        <!-- End Content -->

        @component('components.footer')
        @endcomponent

    </div>    

    <!-- ========================
        End Page Content
    ========================= -->

@endsection    