var QuickNav = function () {

    return {
        init: function () {
           	if( $('.quick-nav').length > 0 ) {
				var stretchyNavs = $('.quick-nav');				
				stretchyNavs.each(function(){
					var stretchyNav = $(this),
						stretchyNavTrigger = stretchyNav.find('.quick-nav-trigger');
					
					stretchyNavTrigger.on('click', function(event){
						event.preventDefault();
						stretchyNav.toggleClass('nav-is-visible');
					});
				});

				$(document).on('click', function(event){
					( !$(event.target).is('.quick-nav-trigger') && !$(event.target).is('.quick-nav-trigger span') ) && stretchyNavs.removeClass('nav-is-visible');
				});
			}
        }
    };
}();

QuickNav.init(); // init metronic core componets
/**
Core script to handle the entire theme and core functions
**/
var QuickSidebar = function () {

    // Handles quick sidebar toggler
    var handleQuickSidebarToggler = function () {
        // quick sidebar toggler
        $('.dropdown-quick-sidebar-toggler a, .page-quick-sidebar-toggler, .quick-sidebar-toggler').click(function (e) {
            $('body').toggleClass('page-quick-sidebar-open'); 
        });
    };

    // Handles quick sidebar chats
    var handleQuickSidebarChat = function () {
        var wrapper = $('.page-quick-sidebar-wrapper');
        var wrapperChat = wrapper.find('.page-quick-sidebar-chat');

        var initChatSlimScroll = function () {
            var chatUsers = wrapper.find('.page-quick-sidebar-chat-users');
            var chatUsersHeight;

            chatUsersHeight = wrapper.height() - wrapper.find('.nav-tabs').outerHeight(true);

            // chat user list 
            App.destroySlimScroll(chatUsers);
            chatUsers.attr("data-height", chatUsersHeight);
            App.initSlimScroll(chatUsers);

            var chatMessages = wrapperChat.find('.page-quick-sidebar-chat-user-messages');
            var chatMessagesHeight = chatUsersHeight - wrapperChat.find('.page-quick-sidebar-chat-user-form').outerHeight(true);
            chatMessagesHeight = chatMessagesHeight - wrapperChat.find('.page-quick-sidebar-nav').outerHeight(true);

            // user chat messages 
            App.destroySlimScroll(chatMessages);
            chatMessages.attr("data-height", chatMessagesHeight);
            App.initSlimScroll(chatMessages);
        };

        initChatSlimScroll();
        App.addResizeHandler(initChatSlimScroll); // reinitialize on window resize

/*        wrapper.find('.page-quick-sidebar-chat-users .media-list > .media').click(function () {
            wrapperChat.addClass("page-quick-sidebar-content-item-shown");
        });

        wrapper.find('.page-quick-sidebar-chat-user .page-quick-sidebar-back-to-list').click(function () {
            wrapperChat.removeClass("page-quick-sidebar-content-item-shown");
        });*/

        var handleChatMessagePost = function (e) {
            e.preventDefault();

            var chatContainer = wrapperChat.find(".page-quick-sidebar-chat-user-messages");
            var input = wrapperChat.find('.page-quick-sidebar-chat-user-form .form-control');

            var text = input.val();
            if (text.length === 0) {
                return;
            }

            var preparePost = function(dir, time, name, avatar, message) {
                var tpl = '';
                tpl += '<div class="post '+ dir +'">';
                tpl += '<img class="avatar" alt="" src="' + Layout.getLayoutImgPath() + avatar +'.jpg"/>';
                tpl += '<div class="message">';
                tpl += '<span class="arrow"></span>';
                tpl += '<a href="#" class="name">Bob Nilson</a>&nbsp;';
                tpl += '<span class="datetime">' + time + '</span>';
                tpl += '<span class="body">';
                tpl += message;
                tpl += '</span>';
                tpl += '</div>';
                tpl += '</div>';

                return tpl;
            };

            // handle post
            var time = new Date();
            var message = preparePost('out', (time.getHours() + ':' + time.getMinutes()), "Bob Nilson", 'avatar3', text);
            message = $(message);
            chatContainer.append(message);

            chatContainer.slimScroll({
                scrollTo: '1000000px'
            });

            input.val("");

            // simulate reply
            setTimeout(function(){
                var time = new Date();
                var message = preparePost('in', (time.getHours() + ':' + time.getMinutes()), "Ella Wong", 'avatar2', 'Lorem ipsum doloriam nibh...');
                message = $(message);
                chatContainer.append(message);

                chatContainer.slimScroll({
                    scrollTo: '1000000px'
                });
            }, 3000);
        };

        wrapperChat.find('.page-quick-sidebar-chat-user-form .btn').click(handleChatMessagePost);
        wrapperChat.find('.page-quick-sidebar-chat-user-form .form-control').keypress(function (e) {
            if (e.which == 13) {
                handleChatMessagePost(e);
                return false;
            }
        });
    };

    // Handles quick sidebar tasks
    var handleQuickSidebarAlerts = function () {
        var wrapper = $('.page-quick-sidebar-wrapper');

        var initAlertsSlimScroll = function () {
            var alertList = wrapper.find('.page-quick-sidebar-alerts-list');
            var alertListHeight;

            alertListHeight = wrapper.height() - 80 - wrapper.find('.nav-justified > .nav-tabs').outerHeight();

            // alerts list 
            App.destroySlimScroll(alertList);
            alertList.attr("data-height", alertListHeight);
            App.initSlimScroll(alertList);
        };

        initAlertsSlimScroll();
        App.addResizeHandler(initAlertsSlimScroll); // reinitialize on window resize
    };

    // Handles quick sidebar settings
    var handleQuickSidebarSettings = function () {
        var wrapper = $('.page-quick-sidebar-wrapper');

        var initSettingsSlimScroll = function () {
            var settingsList = wrapper.find('.page-quick-sidebar-settings-list');
            var settingsListHeight;

            settingsListHeight = wrapper.height() - 80 - wrapper.find('.nav-justified > .nav-tabs').outerHeight();
           
            // alerts list 
            App.destroySlimScroll(settingsList);
            settingsList.attr("data-height", settingsListHeight);
            App.initSlimScroll(settingsList);
        };

        initSettingsSlimScroll();
        App.addResizeHandler(initSettingsSlimScroll); // reinitialize on window resize
    };

    return {

        init: function () {
            //layout handlers
            handleQuickSidebarToggler(); // handles quick sidebar's toggler
            handleQuickSidebarChat(); // handles quick sidebar's chats
            handleQuickSidebarAlerts(); // handles quick sidebar's alerts
            handleQuickSidebarSettings(); // handles quick sidebar's setting
        }
    };

}();

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {    
       QuickSidebar.init(); // init metronic core componets
    });
}
/**
Core script to handle the entire theme and core functions
**/
var Layout = function () {

    var layoutImgPath = 'layouts/layout/img/';  

    var layoutCssPath = 'layouts/layout/css/';

    var resBreakpointMd = App.getResponsiveBreakpoint('md');

    var ajaxContentSuccessCallbacks = [];
    var ajaxContentErrorCallbacks = [];

    //* BEGIN:CORE HANDLERS *//
    // this function handles responsive layout on screen size resize or mobile device rotate.

    // Set proper height for sidebar and content. The content and sidebar height must be synced always.
    var handleSidebarAndContentHeight = function () {
        var content = $('.page-content');
        var sidebar = $('.page-sidebar');
        var body = $('body');
        var height;

        if (body.hasClass("page-footer-fixed") === true && body.hasClass("page-sidebar-fixed") === false) {
            var available_height = App.getViewPort().height - $('.page-footer').outerHeight() - $('.page-header').outerHeight();
            var sidebar_height = sidebar.outerHeight();
            if (sidebar_height > available_height) {
                available_height = sidebar_height + $('.page-footer').outerHeight();
            }
            if (content.height() < available_height) {
                content.css('min-height', available_height);
            }
        } else {
            if (body.hasClass('page-sidebar-fixed')) {
                height = _calculateFixedSidebarViewportHeight();
                if (body.hasClass('page-footer-fixed') === false) {
                    height = height - $('.page-footer').outerHeight();
                }
            } else {
                var headerHeight = $('.page-header').outerHeight();
                var footerHeight = $('.page-footer').outerHeight();

                if (App.getViewPort().width < resBreakpointMd) {
                    height = App.getViewPort().height - headerHeight - footerHeight;
                } else {
                    height = sidebar.height() + 20;
                }

                if ((height + headerHeight + footerHeight) <= App.getViewPort().height) {
                    height = App.getViewPort().height - headerHeight - footerHeight;
                }
            }
            content.css('min-height', height);
        }
    };

    // Handle sidebar menu links
    var handleSidebarMenuActiveLink = function (mode, el, $state) {
        var url = location.hash.toLowerCase();
        var menu = $('.page-sidebar-menu');
 
        if (mode === 'click' || mode === 'set') {
            el = $(el);
        } else if (mode === 'match') {
            menu.find('li > a').each(function () {
                var state = $(this).attr('ui-sref');
                if ($state && state) {
                    if ($state.is(state)) {
                        el = $(this);
                        return;
                    }
                } else {
                    var path = $(this).attr('href');
                    if (path) {
                        // url match condition         
                        path = path.toLowerCase();
                        if (path.length > 1 && url.substr(1, path.length - 1) == path.substr(1)) {
                            el = $(this);
                            return;
                        }
                    }
                }
            });
        }
 
        if (!el || el.size() == 0) {
            return;
        }
 
        if (el.attr('href') == 'javascript:;' ||
            el.attr('ui-sref') == 'javascript:;' ||
            el.attr('href') == '#' ||
            el.attr('ui-sref') == '#'
            ) {
            return;
        }
 
        var slideSpeed = parseInt(menu.data('slide-speed'));
        var keepExpand = menu.data('keep-expanded');
 
        // begin: handle active state
        if (menu.hasClass('page-sidebar-menu-hover-submenu') === false) {
            menu.find('li.nav-item.open').each(function () {
                var match = false;
                $(this).find('li').each(function () {
                    var state = $(this).attr('ui-sref');
                    if ($state && state) {
                        if ($state.is(state)) {
                            match = true;
                            return;
                        }
                    } else if ($(this).find(' > a').attr('href') === el.attr('href')) {
                        match = true;
                        return;
                    }
                });
 
                if (match === true) {
                    return;
                }
 
                $(this).removeClass('open');
                $(this).find('> a > .arrow.open').removeClass('open');
                $(this).find('> .sub-menu').slideUp();
            });
        } else {
            menu.find('li.open').removeClass('open');
        }
 
        menu.find('li.active').removeClass('active');
        menu.find('li > a > .selected').remove();
        // end: handle active state
 
        el.parents('li').each(function () {
            $(this).addClass('active');
            $(this).find('> a > span.arrow').addClass('open');
 
            if ($(this).parent('ul.page-sidebar-menu').size() === 1) {
                $(this).find('> a').append('<span class="selected"></span>');
            }
 
            if ($(this).children('ul.sub-menu').size() === 1) {
                $(this).addClass('open');
            }
        });
 
        if (mode === 'click') {
            if (App.getViewPort().width < resBreakpointMd && $('.page-sidebar').hasClass('in')) { // close the menu on mobile view while laoding a page 
                $('.page-header .responsive-toggler').click();
            }
        }
    };

    // Handle sidebar menu
    var handleSidebarMenu = function () {
        // offcanvas mobile menu 
        $('.page-sidebar-mobile-offcanvas .responsive-toggler').click(function(e) {
            $('body').toggleClass('page-sidebar-mobile-offcanvas-open');
            e.preventDefault();
            e.stopPropagation();
        });

        if ($('body').hasClass('page-sidebar-mobile-offcanvas')) {
            $(document).on('click', function(e) {
                if ($('body').hasClass('page-sidebar-mobile-offcanvas-open')) {
                    if ($(e.target).closest('.page-sidebar-mobile-offcanvas .responsive-toggler').length === 0 && 
                        $(e.target).closest('.page-sidebar-wrapper').length === 0) { 
                        $('body').removeClass('page-sidebar-mobile-offcanvas-open');
                        e.preventDefault();
                        e.stopPropagation();
                    }
                }                
            });
        }

        // handle sidebar link click
        $('.page-sidebar-menu').on('click', 'li > a.nav-toggle, li > a > span.nav-toggle', function (e) {
            var that = $(this).closest('.nav-item').children('.nav-link');

            if (App.getViewPort().width >= resBreakpointMd && !$('.page-sidebar-menu').attr("data-initialized") && $('body').hasClass('page-sidebar-closed') &&  that.parent('li').parent('.page-sidebar-menu').size() === 1) {
                return;
            }

            var hasSubMenu = that.next().hasClass('sub-menu');

            if (App.getViewPort().width >= resBreakpointMd && that.parents('.page-sidebar-menu-hover-submenu').size() === 1) { // exit of hover sidebar menu
                return;
            }

            if (hasSubMenu === false) {
                if (App.getViewPort().width < resBreakpointMd && $('.page-sidebar').hasClass("in")) { // close the menu on mobile view while laoding a page 
                    $('.page-header .responsive-toggler').click();
                }
                return;
            }

            var parent =that.parent().parent();
            var the = that;
            var menu = $('.page-sidebar-menu');
            var sub = that.next();

            var autoScroll = menu.data("auto-scroll");
            var slideSpeed = parseInt(menu.data("slide-speed"));
            var keepExpand = menu.data("keep-expanded");
            
            if (!keepExpand) {
                parent.children('li.open').children('a').children('.arrow').removeClass('open');
                parent.children('li.open').children('.sub-menu:not(.always-open)').slideUp(slideSpeed);
                parent.children('li.open').removeClass('open');
            }

            var slideOffeset = -200;

            if (sub.is(":visible")) {
                $('.arrow', the).removeClass("open");
                the.parent().removeClass("open");
                sub.slideUp(slideSpeed, function () {
                    if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
                        if ($('body').hasClass('page-sidebar-fixed')) {
                            menu.slimScroll({
                                'scrollTo': (the.position()).top
                            });
                        } else {
                            App.scrollTo(the, slideOffeset);
                        }
                    }
                    handleSidebarAndContentHeight();
                });
            } else if (hasSubMenu) {
                $('.arrow', the).addClass("open");
                the.parent().addClass("open");
                sub.slideDown(slideSpeed, function () {
                    if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
                        if ($('body').hasClass('page-sidebar-fixed')) {
                            menu.slimScroll({
                                'scrollTo': (the.position()).top
                            });
                        } else {
                            App.scrollTo(the, slideOffeset);
                        }
                    }
                    handleSidebarAndContentHeight();
                });
            }

            e.preventDefault();
        });

        // handle menu close for angularjs version
        if (App.isAngularJsApp()) {
            $(".page-sidebar-menu li > a").on("click", function(e) {
                if (App.getViewPort().width < resBreakpointMd && $(this).next().hasClass('sub-menu') === false) {
                    $('.page-header .responsive-toggler').click();
                }
            });
        }

        // handle ajax links within sidebar menu
        $('.page-sidebar').on('click', ' li > a.ajaxify', function (e) {
            e.preventDefault();
            App.scrollTop();
            var url = $(this).attr("href");
            var menuContainer = $('.page-sidebar ul');

            menuContainer.children('li.active').removeClass('active');
            menuContainer.children('arrow.open').removeClass('open');

            $(this).parents('li').each(function () {
                $(this).addClass('active');
                $(this).children('a > span.arrow').addClass('open');
            });
            $(this).parents('li').addClass('active');

            if (App.getViewPort().width < resBreakpointMd && $('.page-sidebar').hasClass("in")) { // close the menu on mobile view while laoding a page 
                $('.page-header .responsive-toggler').click();
            }

            Layout.loadAjaxContent(url, $(this));
        });

        // handle ajax link within main content
        $('.page-content').on('click', '.ajaxify', function (e) {
            e.preventDefault();
            App.scrollTop();

            var url = $(this).attr("href");

            if (App.getViewPort().width < resBreakpointMd && $('.page-sidebar').hasClass("in")) { // close the menu on mobile view while laoding a page 
                $('.page-header .responsive-toggler').click();
            }

            Layout.loadAjaxContent(url);
        });

        // handle scrolling to top on responsive menu toggler click when header is fixed for mobile view
        $(document).on('click', '.page-header-fixed-mobile .page-header .responsive-toggler', function(){
            App.scrollTop(); 
        });      
     
        // handle sidebar hover effect        
        handleFixedSidebarHoverEffect();

        // handle the search bar close
        $('.page-sidebar').on('click', '.sidebar-search .remove', function (e) {
            e.preventDefault();
            $('.sidebar-search').removeClass("open");
        });

        // handle the search query submit on enter press
        $('.page-sidebar .sidebar-search').on('keypress', 'input.form-control', function (e) {
            if (e.which == 13) {
                $('.sidebar-search').submit();
                return false; //<---- Add this line
            }
        });

        // handle the search submit(for sidebar search and responsive mode of the header search)
        $('.sidebar-search .submit').on('click', function (e) {
            e.preventDefault();
            if ($('body').hasClass("page-sidebar-closed")) {
                if ($('.sidebar-search').hasClass('open') === false) {
                    if ($('.page-sidebar-fixed').size() === 1) {
                        $('.page-sidebar .sidebar-toggler').click(); //trigger sidebar toggle button
                    }
                    $('.sidebar-search').addClass("open");
                } else {
                    $('.sidebar-search').submit();
                }
            } else {
                $('.sidebar-search').submit();
            }
        });

        // handle close on body click
        if ($('.sidebar-search').size() !== 0) {
            $('.sidebar-search .input-group').on('click', function(e){
                e.stopPropagation();
            });

            $('body').on('click', function() {
                if ($('.sidebar-search').hasClass('open')) {
                    $('.sidebar-search').removeClass("open");
                }
            });
        }
    };

    // Helper function to calculate sidebar height for fixed sidebar layout.
    var _calculateFixedSidebarViewportHeight = function () {
        var sidebarHeight = App.getViewPort().height - $('.page-header').outerHeight(true);
        if ($('body').hasClass("page-footer-fixed")) {
            sidebarHeight = sidebarHeight - $('.page-footer').outerHeight();
        }

        return sidebarHeight;
    };

    // Handles fixed sidebar
    var handleFixedSidebar = function () {
        var menu = $('.page-sidebar-menu');

        handleSidebarAndContentHeight();

        if ($('.page-sidebar-fixed').size() === 0) {
            App.destroySlimScroll(menu);
            return;
        }

        if (App.getViewPort().width >= resBreakpointMd && !$('body').hasClass('page-sidebar-menu-not-fixed')) {
            menu.attr("data-height", _calculateFixedSidebarViewportHeight());
            App.destroySlimScroll(menu);
            App.initSlimScroll(menu);
            handleSidebarAndContentHeight();
        } 
    };

    // Handles sidebar toggler to close/hide the sidebar.
    var handleFixedSidebarHoverEffect = function () {
        if ($('body').hasClass('page-sidebar-fixed')) {
            $('.page-sidebar').on('mouseenter', function () {
                if ($('body').hasClass('page-sidebar-closed')) {
                    $(this).find('.page-sidebar-menu').removeClass('page-sidebar-menu-closed');
                }
            }).on('mouseleave', function () {
                if ($('body').hasClass('page-sidebar-closed')) {
                    $(this).find('.page-sidebar-menu').addClass('page-sidebar-menu-closed');
                }
            });
        }
    };

    // Hanles sidebar toggler
    var handleSidebarToggler = function () {       
        /**
        if (Cookies && Cookies.get('sidebar_closed') === '1' && App.getViewPort().width >= resBreakpointMd) {
            $('body').addClass('page-sidebar-closed');
            $('.page-sidebar-menu').addClass('page-sidebar-menu-closed');
        }
        */

        // handle sidebar show/hide
        $('body').on('click', '.sidebar-toggler', function (e) {
            var body = $('body');
            var sidebar = $('.page-sidebar');
            var sidebarMenu = $('.page-sidebar-menu');
            $(".sidebar-search", sidebar).removeClass("open");

            if (body.hasClass("page-sidebar-closed")) {
                body.removeClass("page-sidebar-closed");
                sidebarMenu.removeClass("page-sidebar-menu-closed");
                if (Cookies) {
                    Cookies.set('sidebar_closed', '0');
                }
            } else {
                body.addClass("page-sidebar-closed");
                sidebarMenu.addClass("page-sidebar-menu-closed");
                if (body.hasClass("page-sidebar-fixed")) {
                    sidebarMenu.trigger("mouseleave");
                }
                if (Cookies) {
                    Cookies.set('sidebar_closed', '1');
                }
            }

            $(window).trigger('resize');
        });
    };

    // Handles the horizontal menu
    var handleHorizontalMenu = function () {
        //handle tab click
        $('.page-header').on('click', '.hor-menu a[data-toggle="tab"]', function (e) {
            e.preventDefault();
            var nav = $(".hor-menu .nav");
            var active_link = nav.find('li.current');
            $('li.active', active_link).removeClass("active");
            $('.selected', active_link).remove();
            var new_link = $(this).parents('li').last();
            new_link.addClass("current");
            new_link.find("a:first").append('<span class="selected"></span>');
        });

        // handle search box expand/collapse        
        $('.page-header').on('click', '.search-form', function (e) {
            $(this).addClass("open");
            $(this).find('.form-control').focus();

            $('.page-header .search-form .form-control').on('blur', function (e) {
                $(this).closest('.search-form').removeClass("open");
                $(this).unbind("blur");
            });
        });

        // handle hor menu search form on enter press
        $('.page-header').on('keypress', '.hor-menu .search-form .form-control', function (e) {
            if (e.which == 13) {
                $(this).closest('.search-form').submit();
                return false;
            }
        });

        // handle header search button click
        $('.page-header').on('mousedown', '.search-form.open .submit', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('.search-form').submit();
        });

        
        $(document).on('click', '.mega-menu-dropdown .dropdown-menu', function (e) {
            e.stopPropagation();
        });
    };

    // Handles Bootstrap Tabs.
    var handleTabs = function () {
        // fix content height on tab click
        $('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function () {
            handleSidebarAndContentHeight();
        });
    };

    // Handles the go to top button at the footer
    var handleGoTop = function () {
        var offset = 300;
        var duration = 500;

        if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {  // ios supported
            $(window).bind("touchend touchcancel touchleave", function(e){
               if ($(this).scrollTop() > offset) {
                    $('.scroll-to-top').fadeIn(duration);
                } else {
                    $('.scroll-to-top').fadeOut(duration);
                }
            });
        } else {  // general 
            $(window).scroll(function() {
                if ($(this).scrollTop() > offset) {
                    $('.scroll-to-top').fadeIn(duration);
                } else {
                    $('.scroll-to-top').fadeOut(duration);
                }
            });
        }
        
        $('.scroll-to-top').click(function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, duration);
            return false;
        });
    };

    // Hanlde 100% height elements(block, portlet, etc)
    var handle100HeightContent = function () {

        $('.full-height-content').each(function(){
            var target = $(this);
            var height;

            height = App.getViewPort().height -
                $('.page-header').outerHeight(true) -
                $('.page-footer').outerHeight(true) -
                $('.page-title').outerHeight(true) -
                $('.page-bar').outerHeight(true);

            if (target.hasClass('portlet')) {
                var portletBody = target.find('.portlet-body');

                App.destroySlimScroll(portletBody.find('.full-height-content-body')); // destroy slimscroll 
                
                height = height -
                    target.find('.portlet-title').outerHeight(true) -
                    parseInt(target.find('.portlet-body').css('padding-top')) -
                    parseInt(target.find('.portlet-body').css('padding-bottom')) - 5;

                if (App.getViewPort().width >= resBreakpointMd && target.hasClass("full-height-content-scrollable")) {
                    height = height - 35;
                    portletBody.find('.full-height-content-body').css('height', height);
                    App.initSlimScroll(portletBody.find('.full-height-content-body'));
                } else {
                    portletBody.css('min-height', height);
                }
            } else {
               App.destroySlimScroll(target.find('.full-height-content-body')); // destroy slimscroll 

                if (App.getViewPort().width >= resBreakpointMd && target.hasClass("full-height-content-scrollable")) {
                    height = height - 35;
                    target.find('.full-height-content-body').css('height', height);
                    App.initSlimScroll(target.find('.full-height-content-body'));
                } else {
                    target.css('min-height', height);
                }
            }
        });        
    };
    //* END:CORE HANDLERS *//

    return {
        // Main init methods to initialize the layout
        //IMPORTANT!!!: Do not modify the core handlers call order.

        initHeader: function() {
            handleHorizontalMenu(); // handles horizontal menu    
        },

        setSidebarMenuActiveLink: function(mode, el) {
            handleSidebarMenuActiveLink(mode, el, null);
        },

        setAngularJsSidebarMenuActiveLink: function(mode, el, $state) {
            handleSidebarMenuActiveLink(mode, el, $state);
        },

        initSidebar: function($state) {
            //layout handlers
            handleFixedSidebar(); // handles fixed sidebar menu
            handleSidebarMenu(); // handles main menu
            handleSidebarToggler(); // handles sidebar hide/show

            if (App.isAngularJsApp()) {      
                handleSidebarMenuActiveLink('match', null, $state); // init sidebar active links 
            }

            App.addResizeHandler(handleFixedSidebar); // reinitialize fixed sidebar on window resize
        },

        initContent: function() {
            handle100HeightContent(); // handles 100% height elements(block, portlet, etc)
            handleTabs(); // handle bootstrah tabs

            App.addResizeHandler(handleSidebarAndContentHeight); // recalculate sidebar & content height on window resize
            App.addResizeHandler(handle100HeightContent); // reinitialize content height on window resize 
        },

        initFooter: function() {
            handleGoTop(); //handles scroll to top functionality in the footer
        },

        init: function () {            
            this.initHeader();
            this.initSidebar(null);
            this.initContent();
            this.initFooter();
        },

        loadAjaxContent: function(url, sidebarMenuLink) {
            var pageContent = $('.page-content .page-content-body');    

            App.startPageLoading({animate: true});
            
            $.ajax({
                type: "GET",
                cache: false,
                url: url,
                dataType: "html",
                success: function (res) {    
                    App.stopPageLoading();
                    pageContent.html(res);

                    for (var i = 0; i < ajaxContentSuccessCallbacks.length; i++) {
                        ajaxContentSuccessCallbacks[i].call(res);
                    }

                    if (sidebarMenuLink.size() > 0 && sidebarMenuLink.parents('li.open').size() === 0) {
                        $('.page-sidebar-menu > li.open > a').click();
                    }
                    
                    Layout.fixContentHeight(); // fix content height
                    App.initAjax(); // initialize core stuff
                },
                error: function (res, ajaxOptions, thrownError) {
                    App.stopPageLoading();
                    pageContent.html('<h4>Could not load the requested content.</h4>');

                    for (var i = 0; i < ajaxContentErrorCallbacks.length; i++) {
                        ajaxContentErrorCallbacks[i].call(res);
                    }                    
                }
            });
        },

        addAjaxContentSuccessCallback: function(callback) {
            ajaxContentSuccessCallbacks.push(callback);
        },

        addAjaxContentErrorCallback: function(callback) {
            ajaxContentErrorCallbacks.push(callback);
        },

        //public function to fix the sidebar and content height accordingly
        fixContentHeight: function () {
            handleSidebarAndContentHeight();
        },

        initFixedSidebarHoverEffect: function() {
            handleFixedSidebarHoverEffect();
        },

        initFixedSidebar: function() {
            handleFixedSidebar();
        },

        getLayoutImgPath: function () {
            return App.getAssetsPath() + layoutImgPath;
        },

        getLayoutCssPath: function () {
            return App.getAssetsPath() + layoutCssPath;
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {    
       Layout.init(); // init metronic core componets
    });
}
/*!
 * jQuery blockUI plugin
 * Version 2.70.0-2014.11.23
 * Requires jQuery v1.7 or later
 *
 * Examples at: http://malsup.com/jquery/block/
 * Copyright (c) 2007-2013 M. Alsup
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Thanks to Amir-Hossein Sobhi for some excellent contributions!
 */

;(function() {
    /*jshint eqeqeq:false curly:false latedef:false */
    "use strict";

    function setup($) {
        $.fn._fadeIn = $.fn.fadeIn;

        var noOp = $.noop || function() {};

        // this bit is to ensure we don't call setExpression when we shouldn't (with extra muscle to handle
        // confusing userAgent strings on Vista)
        var msie = /MSIE/.test(navigator.userAgent);
        var ie6  = /MSIE 6.0/.test(navigator.userAgent) && ! /MSIE 8.0/.test(navigator.userAgent);
        var mode = document.documentMode || 0;
        var setExpr = $.isFunction( document.createElement('div').style.setExpression );

        // global $ methods for blocking/unblocking the entire page
        $.blockUI   = function(opts) { install(window, opts); };
        $.unblockUI = function(opts) { remove(window, opts); };

        // convenience method for quick growl-like notifications  (http://www.google.com/search?q=growl)
        $.growlUI = function(title, message, timeout, onClose) {
            var $m = $('<div class="growlUI"></div>');
            if (title) $m.append('<h1>'+title+'</h1>');
            if (message) $m.append('<h2>'+message+'</h2>');
            if (timeout === undefined) timeout = 3000;

            // Added by konapun: Set timeout to 30 seconds if this growl is moused over, like normal toast notifications
            var callBlock = function(opts) {
                opts = opts || {};

                $.blockUI({
                    message: $m,
                    fadeIn : typeof opts.fadeIn  !== 'undefined' ? opts.fadeIn  : 700,
                    fadeOut: typeof opts.fadeOut !== 'undefined' ? opts.fadeOut : 1000,
                    timeout: typeof opts.timeout !== 'undefined' ? opts.timeout : timeout,
                    centerY: false,
                    showOverlay: false,
                    onUnblock: onClose,
                    css: $.blockUI.defaults.growlCSS
                });
            };

            callBlock();
            var nonmousedOpacity = $m.css('opacity');
            $m.mouseover(function() {
                callBlock({
                    fadeIn: 0,
                    timeout: 30000
                });

                var displayBlock = $('.blockMsg');
                displayBlock.stop(); // cancel fadeout if it has started
                displayBlock.fadeTo(300, 1); // make it easier to read the message by removing transparency
            }).mouseout(function() {
                $('.blockMsg').fadeOut(1000);
            });
            // End konapun additions
        };

        // plugin method for blocking element content
        $.fn.block = function(opts) {
            if ( this[0] === window ) {
                $.blockUI( opts );
                return this;
            }
            var fullOpts = $.extend({}, $.blockUI.defaults, opts || {});
            this.each(function() {
                var $el = $(this);
                if (fullOpts.ignoreIfBlocked && $el.data('blockUI.isBlocked'))
                    return;
                $el.unblock({ fadeOut: 0 });
            });

            return this.each(function() {
                if ($.css(this,'position') == 'static') {
                    this.style.position = 'relative';
                    $(this).data('blockUI.static', true);
                }
                this.style.zoom = 1; // force 'hasLayout' in ie
                install(this, opts);
            });
        };

        // plugin method for unblocking element content
        $.fn.unblock = function(opts) {
            if ( this[0] === window ) {
                $.unblockUI( opts );
                return this;
            }
            return this.each(function() {
                remove(this, opts);
            });
        };

        $.blockUI.version = 2.70; // 2nd generation blocking at no extra cost!

        // override these in your code to change the default behavior and style
        $.blockUI.defaults = {
            // message displayed when blocking (use null for no message)
            message:  '<h1>Please wait...</h1>',

            title: null,		// title string; only used when theme == true
            draggable: true,	// only used when theme == true (requires jquery-ui.js to be loaded)

            theme: false, // set to true to use with jQuery UI themes

            // styles for the message when blocking; if you wish to disable
            // these and use an external stylesheet then do this in your code:
            // $.blockUI.defaults.css = {};
            css: {
                padding:	0,
                margin:		0,
                width:		'30%',
                top:		'40%',
                left:		'35%',
                textAlign:	'center',
                color:		'#000',
                border:		'3px solid #aaa',
                backgroundColor:'#fff',
                cursor:		'wait'
            },

            // minimal style set used when themes are used
            themedCSS: {
                width:	'30%',
                top:	'40%',
                left:	'35%'
            },

            // styles for the overlay
            overlayCSS:  {
                backgroundColor:	'#000',
                opacity:			0.6,
                cursor:				'wait'
            },

            // style to replace wait cursor before unblocking to correct issue
            // of lingering wait cursor
            cursorReset: 'default',

            // styles applied when using $.growlUI
            growlCSS: {
                width:		'350px',
                top:		'10px',
                left:		'',
                right:		'10px',
                border:		'none',
                padding:	'5px',
                opacity:	0.6,
                cursor:		'default',
                color:		'#fff',
                backgroundColor: '#000',
                '-webkit-border-radius':'10px',
                '-moz-border-radius':	'10px',
                'border-radius':		'10px'
            },

            // IE issues: 'about:blank' fails on HTTPS and javascript:false is s-l-o-w
            // (hat tip to Jorge H. N. de Vasconcelos)
            /*jshint scripturl:true */
            iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank',

            // force usage of iframe in non-IE browsers (handy for blocking applets)
            forceIframe: false,

            // z-index for the blocking overlay
            baseZ: 1000,

            // set these to true to have the message automatically centered
            centerX: true, // <-- only effects element blocking (page block controlled via css above)
            centerY: true,

            // allow body element to be stetched in ie6; this makes blocking look better
            // on "short" pages.  disable if you wish to prevent changes to the body height
            allowBodyStretch: true,

            // enable if you want key and mouse events to be disabled for content that is blocked
            bindEvents: true,

            // be default blockUI will supress tab navigation from leaving blocking content
            // (if bindEvents is true)
            constrainTabKey: true,

            // fadeIn time in millis; set to 0 to disable fadeIn on block
            fadeIn:  200,

            // fadeOut time in millis; set to 0 to disable fadeOut on unblock
            fadeOut:  400,

            // time in millis to wait before auto-unblocking; set to 0 to disable auto-unblock
            timeout: 0,

            // disable if you don't want to show the overlay
            showOverlay: true,

            // if true, focus will be placed in the first available input field when
            // page blocking
            focusInput: true,

            // elements that can receive focus
            focusableElements: ':input:enabled:visible',

            // suppresses the use of overlay styles on FF/Linux (due to performance issues with opacity)
            // no longer needed in 2012
            // applyPlatformOpacityRules: true,

            // callback method invoked when fadeIn has completed and blocking message is visible
            onBlock: null,

            // callback method invoked when unblocking has completed; the callback is
            // passed the element that has been unblocked (which is the window object for page
            // blocks) and the options that were passed to the unblock call:
            //	onUnblock(element, options)
            onUnblock: null,

            // callback method invoked when the overlay area is clicked.
            // setting this will turn the cursor to a pointer, otherwise cursor defined in overlayCss will be used.
            onOverlayClick: null,

            // don't ask; if you really must know: http://groups.google.com/group/jquery-en/browse_thread/thread/36640a8730503595/2f6a79a77a78e493#2f6a79a77a78e493
            quirksmodeOffsetHack: 4,

            // class name of the message block
            blockMsgClass: 'blockMsg',

            // if it is already blocked, then ignore it (don't unblock and reblock)
            ignoreIfBlocked: false
        };

        // private data and functions follow...

        var pageBlock = null;
        var pageBlockEls = [];

        function install(el, opts) {
            var css, themedCSS;
            var full = (el == window);
            var msg = (opts && opts.message !== undefined ? opts.message : undefined);
            opts = $.extend({}, $.blockUI.defaults, opts || {});

            if (opts.ignoreIfBlocked && $(el).data('blockUI.isBlocked'))
                return;

            opts.overlayCSS = $.extend({}, $.blockUI.defaults.overlayCSS, opts.overlayCSS || {});
            css = $.extend({}, $.blockUI.defaults.css, opts.css || {});
            if (opts.onOverlayClick)
                opts.overlayCSS.cursor = 'pointer';

            themedCSS = $.extend({}, $.blockUI.defaults.themedCSS, opts.themedCSS || {});
            msg = msg === undefined ? opts.message : msg;

            // remove the current block (if there is one)
            if (full && pageBlock)
                remove(window, {fadeOut:0});

            // if an existing element is being used as the blocking content then we capture
            // its current place in the DOM (and current display style) so we can restore
            // it when we unblock
            if (msg && typeof msg != 'string' && (msg.parentNode || msg.jquery)) {
                var node = msg.jquery ? msg[0] : msg;
                var data = {};
                $(el).data('blockUI.history', data);
                data.el = node;
                data.parent = node.parentNode;
                data.display = node.style.display;
                data.position = node.style.position;
                if (data.parent)
                    data.parent.removeChild(node);
            }

            $(el).data('blockUI.onUnblock', opts.onUnblock);
            var z = opts.baseZ;

            // blockUI uses 3 layers for blocking, for simplicity they are all used on every platform;
            // layer1 is the iframe layer which is used to supress bleed through of underlying content
            // layer2 is the overlay layer which has opacity and a wait cursor (by default)
            // layer3 is the message content that is displayed while blocking
            var lyr1, lyr2, lyr3, s;
            if (msie || opts.forceIframe)
                lyr1 = $('<iframe class="blockUI" style="z-index:'+ (z++) +';display:none;border:none;margin:0;padding:0;position:absolute;width:100%;height:100%;top:0;left:0" src="'+opts.iframeSrc+'"></iframe>');
            else
                lyr1 = $('<div class="blockUI" style="display:none"></div>');

            if (opts.theme)
                lyr2 = $('<div class="blockUI blockOverlay ui-widget-overlay" style="z-index:'+ (z++) +';display:none"></div>');
            else
                lyr2 = $('<div class="blockUI blockOverlay" style="z-index:'+ (z++) +';display:none;border:none;margin:0;padding:0;width:100%;height:100%;top:0;left:0"></div>');

            if (opts.theme && full) {
                s = '<div class="blockUI ' + opts.blockMsgClass + ' blockPage ui-dialog ui-widget ui-corner-all" style="z-index:'+(z+10)+';display:none;position:fixed">';
                if ( opts.title ) {
                    s += '<div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">'+(opts.title || '&nbsp;')+'</div>';
                }
                s += '<div class="ui-widget-content ui-dialog-content"></div>';
                s += '</div>';
            }
            else if (opts.theme) {
                s = '<div class="blockUI ' + opts.blockMsgClass + ' blockElement ui-dialog ui-widget ui-corner-all" style="z-index:'+(z+10)+';display:none;position:absolute">';
                if ( opts.title ) {
                    s += '<div class="ui-widget-header ui-dialog-titlebar ui-corner-all blockTitle">'+(opts.title || '&nbsp;')+'</div>';
                }
                s += '<div class="ui-widget-content ui-dialog-content"></div>';
                s += '</div>';
            }
            else if (full) {
                s = '<div class="blockUI ' + opts.blockMsgClass + ' blockPage" style="z-index:'+(z+10)+';display:none;position:fixed"></div>';
            }
            else {
                s = '<div class="blockUI ' + opts.blockMsgClass + ' blockElement" style="z-index:'+(z+10)+';display:none;position:absolute"></div>';
            }
            lyr3 = $(s);

            // if we have a message, style it
            if (msg) {
                if (opts.theme) {
                    lyr3.css(themedCSS);
                    lyr3.addClass('ui-widget-content');
                }
                else
                    lyr3.css(css);
            }

            // style the overlay
            if (!opts.theme /*&& (!opts.applyPlatformOpacityRules)*/)
                lyr2.css(opts.overlayCSS);
            lyr2.css('position', full ? 'fixed' : 'absolute');

            // make iframe layer transparent in IE
            if (msie || opts.forceIframe)
                lyr1.css('opacity',0.0);

            //$([lyr1[0],lyr2[0],lyr3[0]]).appendTo(full ? 'body' : el);
            var layers = [lyr1,lyr2,lyr3], $par = full ? $('body') : $(el);
            $.each(layers, function() {
                this.appendTo($par);
            });

            if (opts.theme && opts.draggable && $.fn.draggable) {
                lyr3.draggable({
                    handle: '.ui-dialog-titlebar',
                    cancel: 'li'
                });
            }

            // ie7 must use absolute positioning in quirks mode and to account for activex issues (when scrolling)
            var expr = setExpr && (!$.support.boxModel || $('object,embed', full ? null : el).length > 0);
            if (ie6 || expr) {
                // give body 100% height
                if (full && opts.allowBodyStretch && $.support.boxModel)
                    $('html,body').css('height','100%');

                // fix ie6 issue when blocked element has a border width
                if ((ie6 || !$.support.boxModel) && !full) {
                    var t = sz(el,'borderTopWidth'), l = sz(el,'borderLeftWidth');
                    var fixT = t ? '(0 - '+t+')' : 0;
                    var fixL = l ? '(0 - '+l+')' : 0;
                }

                // simulate fixed position
                $.each(layers, function(i,o) {
                    var s = o[0].style;
                    s.position = 'absolute';
                    if (i < 2) {
                        if (full)
                            s.setExpression('height','Math.max(document.body.scrollHeight, document.body.offsetHeight) - (jQuery.support.boxModel?0:'+opts.quirksmodeOffsetHack+') + "px"');
                        else
                            s.setExpression('height','this.parentNode.offsetHeight + "px"');
                        if (full)
                            s.setExpression('width','jQuery.support.boxModel && document.documentElement.clientWidth || document.body.clientWidth + "px"');
                        else
                            s.setExpression('width','this.parentNode.offsetWidth + "px"');
                        if (fixL) s.setExpression('left', fixL);
                        if (fixT) s.setExpression('top', fixT);
                    }
                    else if (opts.centerY) {
                        if (full) s.setExpression('top','(document.documentElement.clientHeight || document.body.clientHeight) / 2 - (this.offsetHeight / 2) + (blah = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"');
                        s.marginTop = 0;
                    }
                    else if (!opts.centerY && full) {
                        var top = (opts.css && opts.css.top) ? parseInt(opts.css.top, 10) : 0;
                        var expression = '((document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + '+top+') + "px"';
                        s.setExpression('top',expression);
                    }
                });
            }

            // show the message
            if (msg) {
                if (opts.theme)
                    lyr3.find('.ui-widget-content').append(msg);
                else
                    lyr3.append(msg);
                if (msg.jquery || msg.nodeType)
                    $(msg).show();
            }

            if ((msie || opts.forceIframe) && opts.showOverlay)
                lyr1.show(); // opacity is zero
            if (opts.fadeIn) {
                var cb = opts.onBlock ? opts.onBlock : noOp;
                var cb1 = (opts.showOverlay && !msg) ? cb : noOp;
                var cb2 = msg ? cb : noOp;
                if (opts.showOverlay)
                    lyr2._fadeIn(opts.fadeIn, cb1);
                if (msg)
                    lyr3._fadeIn(opts.fadeIn, cb2);
            }
            else {
                if (opts.showOverlay)
                    lyr2.show();
                if (msg)
                    lyr3.show();
                if (opts.onBlock)
                    opts.onBlock.bind(lyr3)();
            }

            // bind key and mouse events
            bind(1, el, opts);

            if (full) {
                pageBlock = lyr3[0];
                pageBlockEls = $(opts.focusableElements,pageBlock);
                if (opts.focusInput)
                    setTimeout(focus, 20);
            }
            else
                center(lyr3[0], opts.centerX, opts.centerY);

            if (opts.timeout) {
                // auto-unblock
                var to = setTimeout(function() {
                    if (full)
                        $.unblockUI(opts);
                    else
                        $(el).unblock(opts);
                }, opts.timeout);
                $(el).data('blockUI.timeout', to);
            }
        }

        // remove the block
        function remove(el, opts) {
            var count;
            var full = (el == window);
            var $el = $(el);
            var data = $el.data('blockUI.history');
            var to = $el.data('blockUI.timeout');
            if (to) {
                clearTimeout(to);
                $el.removeData('blockUI.timeout');
            }
            opts = $.extend({}, $.blockUI.defaults, opts || {});
            bind(0, el, opts); // unbind events

            if (opts.onUnblock === null) {
                opts.onUnblock = $el.data('blockUI.onUnblock');
                $el.removeData('blockUI.onUnblock');
            }

            var els;
            if (full) // crazy selector to handle odd field errors in ie6/7
                els = $('body').children().filter('.blockUI').add('body > .blockUI');
            else
                els = $el.find('>.blockUI');

            // fix cursor issue
            if ( opts.cursorReset ) {
                if ( els.length > 1 )
                    els[1].style.cursor = opts.cursorReset;
                if ( els.length > 2 )
                    els[2].style.cursor = opts.cursorReset;
            }

            if (full)
                pageBlock = pageBlockEls = null;

            if (opts.fadeOut) {
                count = els.length;
                els.stop().fadeOut(opts.fadeOut, function() {
                    if ( --count === 0)
                        reset(els,data,opts,el);
                });
            }
            else
                reset(els, data, opts, el);
        }

        // move blocking element back into the DOM where it started
        function reset(els,data,opts,el) {
            var $el = $(el);
            if ( $el.data('blockUI.isBlocked') )
                return;

            els.each(function(i,o) {
                // remove via DOM calls so we don't lose event handlers
                if (this.parentNode)
                    this.parentNode.removeChild(this);
            });

            if (data && data.el) {
                data.el.style.display = data.display;
                data.el.style.position = data.position;
                data.el.style.cursor = 'default'; // #59
                if (data.parent)
                    data.parent.appendChild(data.el);
                $el.removeData('blockUI.history');
            }

            if ($el.data('blockUI.static')) {
                $el.css('position', 'static'); // #22
            }

            if (typeof opts.onUnblock == 'function')
                opts.onUnblock(el,opts);

            // fix issue in Safari 6 where block artifacts remain until reflow
            var body = $(document.body), w = body.width(), cssW = body[0].style.width;
            body.width(w-1).width(w);
            body[0].style.width = cssW;
        }

        // bind/unbind the handler
        function bind(b, el, opts) {
            var full = el == window, $el = $(el);

            // don't bother unbinding if there is nothing to unbind
            if (!b && (full && !pageBlock || !full && !$el.data('blockUI.isBlocked')))
                return;

            $el.data('blockUI.isBlocked', b);

            // don't bind events when overlay is not in use or if bindEvents is false
            if (!full || !opts.bindEvents || (b && !opts.showOverlay))
                return;

            // bind anchors and inputs for mouse and key events
            var events = 'mousedown mouseup keydown keypress keyup touchstart touchend touchmove';
            if (b)
                $(document).bind(events, opts, handler);
            else
                $(document).unbind(events, handler);

            // former impl...
            //		var $e = $('a,:input');
            //		b ? $e.bind(events, opts, handler) : $e.unbind(events, handler);
        }

        // event handler to suppress keyboard/mouse events when blocking
        function handler(e) {
            // allow tab navigation (conditionally)
            if (e.type === 'keydown' && e.keyCode && e.keyCode == 9) {
                if (pageBlock && e.data.constrainTabKey) {
                    var els = pageBlockEls;
                    var fwd = !e.shiftKey && e.target === els[els.length-1];
                    var back = e.shiftKey && e.target === els[0];
                    if (fwd || back) {
                        setTimeout(function(){focus(back);},10);
                        return false;
                    }
                }
            }
            var opts = e.data;
            var target = $(e.target);
            if (target.hasClass('blockOverlay') && opts.onOverlayClick)
                opts.onOverlayClick(e);

            // allow events within the message content
            if (target.parents('div.' + opts.blockMsgClass).length > 0)
                return true;

            // allow events for content that is not being blocked
            return target.parents().children().filter('div.blockUI').length === 0;
        }

        function focus(back) {
            if (!pageBlockEls)
                return;
            var e = pageBlockEls[back===true ? pageBlockEls.length-1 : 0];
            if (e)
                e.focus();
        }

        function center(el, x, y) {
            var p = el.parentNode, s = el.style;
            var l = ((p.offsetWidth - el.offsetWidth)/2) - sz(p,'borderLeftWidth');
            var t = ((p.offsetHeight - el.offsetHeight)/2) - sz(p,'borderTopWidth');
            if (x) s.left = l > 0 ? (l+'px') : '0';
            if (y) s.top  = t > 0 ? (t+'px') : '0';
        }

        function sz(el, p) {
            return parseInt($.css(el,p),10)||0;
        }

    }


    /*global define:true */
    if (typeof define === 'function' && define.amd && define.amd.jQuery) {
        define(['jquery'], setup);
    } else {
        setup(jQuery);
    }

})();

//# sourceMappingURL=layout.js.map
