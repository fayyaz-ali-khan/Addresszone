<div class="iq-sidebar  sidebar-default ">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
        <a href="../backend/index.html" class="header-logo">
            <img src="{{ asset(isset($general_settings->logo) ? 'storage/' . $general_settings?->logo : 'assets/logo/logo-1.png') }}"
                class="img-fluid rounded-normal light-logo" style="height: 48px" alt="logo">
        </a>

        <div class="iq-menu-bt-sidebar ml-0">
            <i class="las la-bars wrapper-menu"></i>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="svg-icon">
                        <svg class="svg-icon" id="p-dash1" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                            </path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <span class="ml-4">Dashboards</span>
                    </a>
                </li>
                <li class=" {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <a href="#people" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash8" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span class="ml-4">Customers</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="people"
                        class="iq-submenu collapse {{ request()->routeIs('admin.customers.*') ? 'show' : '' }} "
                        data-parent="#iq-sidebar-toggle">
                        <li class="">
                            <a href="{{ route('admin.customers.index') }}">
                                <i class="las la-minus"></i><span>Customers</span>
                            </a>
                        </li>
                        <li class="">
                            <a href=href="{{ route('admin.customers.create') }}">
                                <i class="las la-minus"></i><span>Add Customers</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class=" {{ request('type') == 'paid' || request('type') == 'unpaid' ? 'active' : '' }}">
                    <a href="#product" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash2" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <span class="ml-4">Orders</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="product"
                        class="iq-submenu collapse {{ request('type') == 'paid' || request('type') == 'unpaid' ? 'show' : '' }}"
                        data-parent="#iq-sidebar-toggle">
                        <li class="">
                            <a href="{{ route('admin.orders.index', ['type' => 'unpaid']) }}">
                                <i class="las la-minus"></i><span>Unpaid Orders</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('admin.orders.index', ['type' => 'paid']) }}">
                                <i class="las la-minus"></i><span>Paid Orders</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.documents.index') }}" class="">
                        <svg class="svg-icon" id="p-dash7" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span class="ml-4">Documents</span>
                    </a>

                </li>

                <li
                    class=" {{ request()->routeIs('admin.services.*') || request()->routeIs('admin.service_categories.*') ? 'active' : '' }}">
                    <a href="#services" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash8" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span class="ml-4">Services</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="services"
                        class="iq-submenu collapse {{ request()->routeIs('admin.services.*') ? 'show' : '' }} "
                        data-parent="#iq-sidebar-toggle">
                        <li class="">
                            <a href="{{ route('admin.services.index') }}">
                                <i class="las la-minus"></i><span>Services</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('admin.services.create') }}">
                                <i class="las la-minus"></i><span>Add Service</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('admin.service_categories.index') }}" class="">
                                <i class="las la-minus"></i><span>Service Categories</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class=" {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.coupons.index') }}">
                        <svg class="svg-icon" id="p-dash5" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2">
                            </rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                        <span class="ml-4">Coupons</span>

                    </a>

                </li>

                <li class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.index') }}" class="">
                        <svg class="svg-icon" id="p-dash7" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span class="ml-4">Reports</span>
                    </a>

                </li>

                <li
                    class=" {{ request()->routeIs('admin.blog-categories.*') || request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    <a href="#blogs" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash8" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span class="ml-4">Blogs</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="blogs"
                        class="iq-submenu collapse {{ request()->routeIs('admin.blogs.*') || request()->routeIs('admin.blog-categories.*') ? 'show' : '' }} "
                        data-parent="#iq-sidebar-toggle">
                        <li class="">
                            <a href="{{ route('admin.blogs.index') }}">
                                <i class="las la-minus"></i><span>Blogs</span>
                            </a>
                        </li>

                        <li class="">
                            <a href="{{ route('admin.blog-categories.index') }}" class="">
                                <i class="las la-minus"></i><span>Categories</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="">
                    <a href="/" target="_blank" title="View Site">
                        <svg class="svg-icon" id="site-icon" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 0 20"></path>
                            <path d="M12 2a15.3 15.3 0 0 0 0 20"></path>
                        </svg>
                        </svg> <span class="ml-4">Site</span>
                    </a>

                </li>




                <li class="{{ request()->routeIs('admin.send-notifications.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.send-notifications.index') }}" class="">
                        <svg class="svg-icon" id="p-dash7" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span class="ml-4">Send Notification</span>
                    </a>

                </li>
                <li class="{{ request()->routeIs('admin.currencies.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.currencies.index') }}" class="">
                        <svg class="svg-icon" id="p-dash7" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span class="ml-4">Currency</span>
                    </a>

                </li>
                <li class="{{ request()->routeIs('admin.email_templates.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.email_templates.index') }}" class="">
                        <svg class="svg-icon" id="p-settings" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path
                                d="M19.4 12a7.5 7.5 0 0 0 .6-2h-2a5.5 5.5 0 0 1-1-2.6l1.6-1.6a7.5 7.5 0 0 0-2-2L16 7a5.5 5.5 0 0 1-2.6-1H12a7.5 7.5 0 0 0-2 .6L8.4 3a7.5 7.5 0 0 0-2 2L7 5.6A5.5 5.5 0 0 1 5 8v2a7.5 7.5 0 0 0-.6 2h2a5.5 5.5 0 0 1 1 2.6L4.6 17a7.5 7.5 0 0 0 2 2L8 17a5.5 5.5 0 0 1 2.6 1h2a7.5 7.5 0 0 0 2-.6l1.6 1.6a7.5 7.5 0 0 0 2-2L17 16a5.5 5.5 0 0 1 1-2.6h2a7.5 7.5 0 0 0-.6-2Z">
                            </path>
                        </svg> <span class="ml-4">Email Templates</span>
                    </a>

                </li>
                <li class="{{ request()->routeIs('admin.general_settings.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.general_settings.index') }}" class="">
                        <svg class="svg-icon" id="p-settings" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path
                                d="M19.4 12a7.5 7.5 0 0 0 .6-2h-2a5.5 5.5 0 0 1-1-2.6l1.6-1.6a7.5 7.5 0 0 0-2-2L16 7a5.5 5.5 0 0 1-2.6-1H12a7.5 7.5 0 0 0-2 .6L8.4 3a7.5 7.5 0 0 0-2 2L7 5.6A5.5 5.5 0 0 1 5 8v2a7.5 7.5 0 0 0-.6 2h2a5.5 5.5 0 0 1 1 2.6L4.6 17a7.5 7.5 0 0 0 2 2L8 17a5.5 5.5 0 0 1 2.6 1h2a7.5 7.5 0 0 0 2-.6l1.6 1.6a7.5 7.5 0 0 0 2-2L17 16a5.5 5.5 0 0 1 1-2.6h2a7.5 7.5 0 0 0-.6-2Z">
                            </path>
                        </svg> <span class="ml-4">Settings</span>
                    </a>

                </li>

                <li class="">
                    <a href="/" target="_blank" title="View Site">
                        <svg class="svg-icon" id="site-icon" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 0 20"></path>
                            <path d="M12 2a15.3 15.3 0 0 0 0 20"></path>
                        </svg>
                        </svg> <span class="ml-4">Site</span>
                    </a>

                </li>


            </ul>
        </nav>

        <div class="p-3"></div>
    </div>
</div>
