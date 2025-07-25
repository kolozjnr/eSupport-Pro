
        <!-- Sidenav Menu -->
        <div class="app-menu">

            <!-- Sidenav Brand Logo -->
            <a href="/dashboard" class="logo-box">
                <!-- Light Brand Logo -->
                <div class="logo-light">
                    <img src="{{ asset('storage/'. $settings->light_logo)}}" class="h-24 hover:h-10 w-40 hover:w-32" alt="Light logo">
                    <img src="{{ asset('storage/'. $settings->light_logo_sm)}}" class="logo-sm" alt="Small logo">
                </div>

                <!-- Dark Brand Logo -->
                <div class="logo-dark">
                    <img src="{{ asset('storage/' . $settings->dark_logo) }}" class="h-32 hover:h-10 w-40 hover:w-32" alt="Dark logo">
                    <img src="{{ asset('storage/'. $settings->dark_logo_sm)}}" class="logo-sm" alt="Small logo">
                </div>
            </a>

            <!-- Sidenav Menu Toggle Button -->
            <button id="button-hover-toggle" class="absolute top-5 end-2 rounded-full p-1.5">
                <span class="sr-only">Menu Toggle Button </span>
                <i class="mgc_round_line text-xl"></i>
            </button>

            <!--- Menu -->
            <div class="srcollbar" data-simplebar>
                <ul class="menu" data-fc-type="accordion">
                    <li class="menu-title">Menu</li>

                    <li class="menu-item">
                        <a href="{{ route('dashboard')}}" class="menu-link">
                            <span class="menu-icon"><i class="mgc_home_3_line"></i></span>
                            <span class="menu-text"> Dashboard </span>
                        </a>
                    </li>

                    <li class="menu-title">{{$settings->short_name}}</li>

                   
                    <li class="menu-item">
                        {{-- <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link {{ request()->is('create*') || request()->is('draft*') ? 'open' : '' }}"> --}}
                            <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link {{ request()->is('tickets') || request()->is('tickets/create') || request()->is('tickets/draft') || request()->is('tickets/view-drafts') ? 'open' : '' }}">
                            <span class="menu-icon"><i class="mgc_building_2_line"></i></span>
                            <span class="menu-text"> Manage Tickets </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="{{ route('tickets.index')}}" class="menu-link active">
                                    <span class="menu-text">Tickets</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('tickets.create')}}" class="menu-link">
                                    <span class="menu-text">Create Ticket</span>
                                </a>
                            </li>
                            
                            <li class="menu-item">
                                <a href="{{ route('tickets.draft')}}" class="menu-link">
                                    <span class="menu-text">Draft</span>
                                </a>
                            </li>
                             <li class="menu-item">
                                <a href="{{ route('tickets.view-drafts')}}" class="menu-link">
                                    <span class="menu-text">View Draft</span>
                                </a>
                            </li>
                            
                            
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_box_3_line"></i></span>
                            <span class="menu-text"> Invoice </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                {{-- <a href="pages-starter.html" class="menu-link">
                                    <span class="menu-text">Starter</span>
                                </a> --}}
                                <a href="{{ route('invoices.index')}}" class="menu-link">
                                    <span class="menu-text">View Subscriptions</span>
                                </a>
                            </li>
                            {{-- <li class="menu-item">
                                 <a href="{{ route('invoices.report')}}" class="menu-link">
                                    <span class="menu-text">Financial Report and Analytics</span>
                                </a>
                            </li> --}}
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_layout_line"></i></span>
                            <span class="menu-text"> Business Management </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="{{ route('tickets.view-feedback')}}" class="menu-link">
                                    <span class="menu-text">Customer Interaction History</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('customers.onboard')}}" class="menu-link">
                                    <span class="menu-text">Customer Onboarding</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_box_3_line"></i></span>
                            <span class="menu-text"> User Management </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            
                            <li class="menu-item">
                                <a href="{{route('users.create')}}" class="menu-link">
                                    <span class="menu-text">Create user</span>
                                </a>
                            </li>
                            {{-- <li class="menu-item">
                                <a href="{{route('users.manage-roles')}}" class="menu-link">
                                    <span class="menu-text">Role Management</span>
                                </a>
                            </li> --}}
                            
                            <li class="menu-item">
                                <a href="{{route('users.knowledgebase')}}" class="menu-link">
                                    <span class="menu-text">Knowledge Base</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                     <li class="menu-item">
                        <a href="{{route('customers.pricing')}}" class="menu-link">
                            <span class="menu-icon"><i class="mgc_box_2_line"></i></span>
                            <span class="menu-text"> Pricing </span>
                        </a>
                    </li>

                    
                    


                    {{-- <li class="menu-item">
                        <a href="apps-file-manager.html" class="menu-link">
                            <span class="menu-icon"><i class="mgc_folder_2_line"></i></span>
                            <span class="menu-text"> File Manager </span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="apps-kanban.html" class="menu-link">
                            <span class="menu-icon"><i class="mgc_task_2_line"></i></span>
                            <span class="menu-text">Kanban</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_building_2_line"></i></span>
                            <span class="menu-text"> Project </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="apps-project-list.html" class="menu-link">
                                    <span class="menu-text">List</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="apps-project-detail.html" class="menu-link">
                                    <span class="menu-text">Detail</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="apps-project-create.html" class="menu-link">
                                    <span class="menu-text">Create</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-title">Custom</li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_user_3_line"></i></span>
                            <span class="menu-text"> Auth Pages </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="auth-login.html" class="menu-link">
                                    <span class="menu-text">Log In</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-register.html" class="menu-link">
                                    <span class="menu-text">Register</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-recoverpw.html" class="menu-link">
                                    <span class="menu-text">Recover Password</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-lock-screen.html" class="menu-link">
                                    <span class="menu-text">Lock Screen</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_box_3_line"></i></span>
                            <span class="menu-text"> Extra Pages </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="pages-starter.html" class="menu-link">
                                    <span class="menu-text">Starter</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-timeline.html" class="menu-link">
                                    <span class="menu-text">Timeline</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-invoice.html" class="menu-link">
                                    <span class="menu-text">Invoice</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-gallery.html" class="menu-link">
                                    <span class="menu-text">Gallery</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-faqs.html" class="menu-link">
                                    <span class="menu-text">FAQs</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-pricing.html" class="menu-link">
                                    <span class="menu-text">Pricing</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-maintenance.html" class="menu-link">
                                    <span class="menu-text">Maintenance</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-coming-soon.html" class="menu-link">
                                    <span class="menu-text">Coming Soon</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-404.html" class="menu-link">
                                    <span class="menu-text">Error 404</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-404-alt.html" class="menu-link">
                                    <span class="menu-text">Error 404-alt</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-500.html" class="menu-link">
                                    <span class="menu-text">Error 500</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_layout_line"></i></span>
                            <span class="menu-text"> Layout </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="layout-hover-view.html" target="_blank" class="menu-link">
                                    <span class="menu-text">Hovered Menu</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="layout-icon-view.html" target="_blank" class="menu-link">
                                    <span class="menu-text">Icon View Menu</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="layout-compact-view.html" target="_blank" class="menu-link">
                                    <span class="menu-text">Compact Menu</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="layout-mobile-view.html" target="_blank" class="menu-link">
                                    <span class="menu-text">Mobile View Menu</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="layout-hidden.html" target="_blank" class="menu-link">
                                    <span class="menu-text">Hidden Menu</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-title">Elements</li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_classify_2_line"></i></span>
                            <span class="menu-text"> Components </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="ui-accordions.html" class="menu-link">
                                    <span class="menu-text">Accordions</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-alerts.html" class="menu-link">
                                    <span class="menu-text">Alerts</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-avatars.html" class="menu-link">
                                    <span class="menu-text">Avatars</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-buttons.html" class="menu-link">
                                    <span class="menu-text">Buttons</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-badges.html" class="menu-link">
                                    <span class="menu-text">Badges</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-breadcrumbs.html" class="menu-link">
                                    <span class="menu-text">Breadcrumb</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-cards.html" class="menu-link">
                                    <span class="menu-text">Cards</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-collapse.html" class="menu-link">
                                    <span class="menu-text">Collapse</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-dismissible.html" class="menu-link">
                                    <span class="menu-text">Dismissible</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-dropdowns.html" class="menu-link">
                                    <span class="menu-text">Dropdowns</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-progress.html" class="menu-link">
                                    <span class="menu-text">Progress</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-skeleton.html" class="menu-link">
                                    <span class="menu-text">Skeleton</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-spinners.html" class="menu-link">
                                    <span class="menu-text">Spinners</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-list-group.html" class="menu-link">
                                    <span class="menu-text">List Group</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-ratio.html" class="menu-link">
                                    <span class="menu-text">Ratio</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-tabs.html" class="menu-link">
                                    <span class="menu-text">Tab</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-modals.html" class="menu-link">
                                    <span class="menu-text">Modals</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-offcanvas.html" class="menu-link">
                                    <span class="menu-text">Offcanvas</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-popovers.html" class="menu-link">
                                    <span class="menu-text">Popovers</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-tooltips.html" class="menu-link">
                                    <span class="menu-text">Tooltips</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-typography.html" class="menu-link">
                                    <span class="menu-text">Typography</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_box_3_line"></i></span>
                            <span class="menu-text"> Extended </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="extended-swiper.html" class="menu-link">
                                    <span class="menu-text">Swiper</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-nestable.html" class="menu-link">
                                    <span class="menu-text">Nestable List</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-ratings.html" class="menu-link">
                                    <span class="menu-text">Ratings</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-animation.html" class="menu-link">
                                    <span class="menu-text">Animation</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-player.html" class="menu-link">
                                    <span class="menu-text">Player</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-scrollbar.html" class="menu-link">
                                    <span class="menu-text">Scrollbar</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-sweet-alert.html" class="menu-link">
                                    <span class="menu-text">Sweet Alert</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-tour.html" class="menu-link">
                                    <span class="menu-text">Tour Page</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-tippy-tooltips.html" class="menu-link">
                                    <span class="menu-text">Tippy Tooltip</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-lightbox.html" class="menu-link">
                                    <span class="menu-text">Lightbox</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_file_check_line"></i></span>
                            <span class="menu-text"> Forms </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="forms-elements.html" class="menu-link">
                                    <span class="menu-text">Form Elements</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-select.html" class="menu-link">
                                    <span class="menu-text">Select</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-range.html" class="menu-link">
                                    <span class="menu-text">Range</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-pickers.html" class="menu-link">
                                    <span class="menu-text">Pickers</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-masks.html" class="menu-link">
                                    <span class="menu-text">Masks</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-editor.html" class="menu-link">
                                    <span class="menu-text">Editor</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-file-uploads.html" class="menu-link">
                                    <span class="menu-text">File Uploads</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-validation.html" class="menu-link">
                                    <span class="menu-text">Validation</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-layout.html" class="menu-link">
                                    <span class="menu-text">Form Layout</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_layout_grid_line"></i></span>
                            <span class="menu-text"> Tables </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="tables-basic.html" class="menu-link">
                                    <span class="menu-text">Basic Tables</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="tables-datatables.html" class="menu-link">
                                    <span class="menu-text">Data Tables</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_dribbble_line"></i></span>
                            <span class="menu-text"> Icons </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="icons-mingcute.html" class="menu-link">
                                    <span class="menu-text">Mingcute</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="icons-feather.html" class="menu-link">
                                    <span class="menu-text">Feather</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="icons-material-symbols.html" class="menu-link">
                                    <span class="menu-text">Material Symbols </span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="charts.html" class="menu-link">
                            <span class="menu-icon"><i class="mgc_chart_bar_line"></i></span>
                            <span class="menu-text"> Chart </span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_location_line"></i></span>
                            <span class="menu-text"> Maps </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="maps-vector.html" class="menu-link">
                                    <span class="menu-text">Vector Maps</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="maps-google.html" class="menu-link">
                                    <span class="menu-text">Google Maps</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-title">Documentation</li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="mgc_document_line"></i></span>
                            <span class="menu-text"> Documentation </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="docs-introduction.html" class="menu-link">
                                    <span class="menu-text">Introduction</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="docs-installation.html" class="menu-link">
                                    <span class="menu-text">Installation</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="docs-customization.html" class="menu-link">
                                    <span class="menu-text">Customization</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="docs-changelog.html" class="menu-link">
                                    <span class="menu-text">Changelog</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul> --}}

                <!-- Help Box Widget -->
                {{-- <div class="my-10 mx-5">
                    <div class="help-box p-6 bg-black/5 text-center rounded-md">
                        <div class="flex justify-center mb-4">
                            <svg width="30" height="18" aria-hidden="true">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15 0c-4 0-6.5 2-7.5 6 1.5-2 3.25-2.75 5.25-2.25 1.141.285 1.957 1.113 2.86 2.03C17.08 7.271 18.782 9 22.5 9c4 0 6.5-2 7.5-6-1.5 2-3.25 2.75-5.25 2.25-1.141-.285-1.957-1.113-2.86-2.03C20.42 1.728 18.718 0 15 0ZM7.5 9C3.5 9 1 11 0 15c1.5-2 3.25-2.75 5.25-2.25 1.141.285 1.957 1.113 2.86 2.03C9.58 16.271 11.282 18 15 18c4 0 6.5-2 7.5-6-1.5 2-3.25 2.75-5.25 2.25-1.141-.285-1.957-1.113-2.86-2.03C12.92 10.729 11.218 9 7.5 9Z" fill="#38BDF8"></path>
                            </svg>
                        </div>
                        <h5 class="mb-2">Unlimited Access</h5>
                        <p class="mb-3">Upgrade to plan to get access to unlimited reports</p>
                        <a href="javascript: void(0);" class="btn btn-sm bg-secondary text-white">Upgrade</a>
                    </div>
                </div> --}}
            </div>
        </div>
        <!-- Sidenav Menu End  -->













{{-- <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav> --}}
