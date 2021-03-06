            <!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                <!-- User Info -->
                <div class="bg-image bg-image-bottom" style="background-image: url('{{ url('/') }}assets/media/photos/photo44.jpg');">
                    <div class="bg-primary-dark-op py-30">
                        <div class="content content-full text-center">
                            <!-- Avatar -->
                            <div class="mb-15">
                                <i class="fa fa-music fa-4x text-warning-light"></i>
                            </div>
                            <!-- END Avatar -->

                            <!-- Personal -->
                            <h1 class="h3 text-white font-w700 mb-10">{{ user.name }}</h1>
                            <h2 class="h5 text-white-op">
                                {% if user.data is defined %}{{ user.data.bio }}{% endif %}
                            </h2>
{#                            <h2 class="h5 text-white-op">#}
{#                                Poin Dengar: <p class="text-primary-light">100</p>#}
{#                            </h2>#}
                            <!-- END Personal -->

                            <!-- Actions -->
                            {% if auth is defined and user.id != auth.id %}
                                {% if not followed %}
                                <form action="{{ url({'for': 'main-user-follow', 'username': user.username}) }}" method="post" style="display: inline-block">
                                    <button type="submit" class="btn btn-rounded btn-hero btn-sm btn-alt-success mb-5">
                                        <i class="fa fa-plus mr-5"></i> Follow
                                    </button>
                                </form>
                                {% else %}
                                <form action="{{ url({'for': 'main-user-unfollow', 'username': user.username}) }}" method="post" style="display: inline-block">
                                    <button type="submit" class="btn btn-rounded btn-hero btn-sm btn-alt-danger mb-5">
                                        <i class="fa fa-minus mr-5"></i> Unfollow
                                    </button>
                                </form>
                                {% endif %}
                            {% endif %}

                            {#{% if auth is defined and auth.role == constant('Dengarin\Main\Models\User::ROLE_AMPLIFIER') and
                                user.role == constant('Dengarin\Main\Models\User::ROLE_SOUND') %}
                                <a href="{{ url({'for': 'collaboration-event-collab', 'username': user.username}) }}"
                                   class="btn btn-rounded btn-hero btn-sm btn-alt-info mb-5 ml-5">
                                    <i class="fa fa-group mr-5"></i> Collaborate!
                                </a>
                            {% endif %}#}

                            {% if auth is not defined %}
                                <a href="{{ url({'for': 'signin'}) }}" class="btn btn-rounded btn-hero btn-sm btn-alt-success mb-5">
                                    <i class="fa fa-plus mr-5"></i> Follow
                                </a>
                                {% if user.role == constant('Dengarin\Main\Models\User::ROLE_SOUND') %}
                                    <a href="{{ url({'for': 'signin'}) }}" class="btn btn-rounded btn-hero btn-sm btn-alt-info mb-5 ml-5">
                                        <i class="fa fa-plus mr-5"></i> Collaborate!
                                    </a>
                                {% endif %}
                            {% endif %}
                            <!-- END Actions -->
                        </div>
                    </div>
                </div>
                <!-- END User Info -->

                <!-- Main Content -->
                <div class="content">

                    {{ flashSession.output() }}

                    <!-- Simple Gallery (.js-gallery class is initialized in Helpers.magnific()) -->
                    <!-- For more info and examples you can check out http://dimsemenov.com/plugins/magnific-popup/ -->
                    <h2 class="content-heading">Events</h2>
                    <div class="row items-push js-gallery img-fluid-100">
                        <!-- Calendar and Events functionality is initialized in js/pages/be_comp_calendar.min.js which was auto compiled from _es6/pages/be_comp_calendar.js -->
                        <!-- For more info and examples you can check out https://fullcalendar.io/ -->
                        <div class="block">
                            <div class="block-content">
                                <div class="row items-push">
                                    <div class="col-xl-8 offset-xl-2">
                                        <!-- Calendar Container -->
                                        <div class="js-calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Calendar -->

                    </div>
                    <!-- END Simple Gallery -->

{#                    <!-- Music -->#}
{#                    <h2 class="content-heading">#}
{#                        <!--<button type="button" class="btn btn-sm btn-rounded btn-alt-secondary float-right">View More..</button>-->#}
{#                        <i class="si si-note mr-5"></i> Music#}
{#                    </h2>#}
{#                    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">#}
{#                        <div class="block-content block-content-full">#}
{#                            <p class="font-size-sm text-muted float-sm-right mb-5"><em>3:30</em></p>#}
{#                            <h4 class="font-size-default text-primary mb-0">#}
{#                                <i class="fa fa-music text-muted mr-5"></i> 5 things#}
{#                            </h4>#}
{#                        </div>#}
{#                    </a>#}
{#                    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">#}
{#                        <div class="block-content block-content-full">#}
{#                            <p class="font-size-sm text-muted float-sm-right mb-5"><em>2:42</em></p>#}
{#                            <h4 class="font-size-default text-primary mb-0">#}
{#                                <i class="fa fa-music text-muted mr-5"></i> Soul Sand#}
{#                            </h4>#}
{#                        </div>#}
{#                    </a>#}
{#                    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">#}
{#                        <div class="block-content block-content-full">#}
{#                            <p class="font-size-sm text-muted float-sm-right mb-5"><em>2:42</em></p>#}
{#                            <h4 class="font-size-default text-primary mb-0">#}
{#                                <i class="fa fa-music text-muted mr-5"></i> 10 Important things I wish I knew#}
{#                            </h4>#}
{#                        </div>#}
{#                    </a>#}
{#                    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">#}
{#                        <div class="block-content block-content-full">#}
{#                            <p class="font-size-sm text-muted float-sm-right mb-5"><em>2:42</em></p>#}
{#                            <h4 class="font-size-default text-primary mb-0">#}
{#                                <i class="fa fa-music text-muted mr-5"></i> Bringing your productivity back#}
{#                            </h4>#}
{#                        </div>#}
{#                    </a>#}
{#                    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">#}
{#                        <div class="block-content block-content-full">#}
{#                            <p class="font-size-sm text-muted float-sm-right mb-5"><em>2:42</em></p>#}
{#                            <h4 class="font-size-default text-primary mb-0">#}
{#                                <i class="fa fa-music text-muted mr-5"></i> Super Smooth#}
{#                            </h4>#}
{#                        </div>#}
{#                    </a>#}
{#                    <!-- END Articles -->#}
                </div>
                <!-- END Main Content -->
                <!-- END Page Content -->

            </main>
            <!-- END Main Container -->