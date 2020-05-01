            <!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                <div class="content">
                    <!-- Options Zoom Out -->
                    <h2 class="content-heading">Challenges</h2>
                    <div class="row items-push">
                        {% if competition %}
                        {% for c in competition %}
                        <div class="col-md-4 animated fadeIn">
                            <div class="options-container fx-item-zoom-in fx-overlay-zoom-out">
                                <img class="img-fluid options-item" src="{{url("/")}}challenge_competition/{{ c.image }}" alt="">
                                <div class="options-overlay bg-primary-dark-op">
                                    <div class="options-overlay-content">
                                        <h3 class="h4 text-white mb-5">{{ c.title }}</h3>
                                        <h4 class="h6 text-white-op mb-15">{{ c.duedate }}</h4>
                                        <a class="btn btn-sm btn-rounded btn-alt-info min-width-75" href="{{url({'for':'competition'})}}/{{c.idcomp}}">
                                            <i class="fa fa-search"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {% endfor %}
                        {% endif %}                                                                   
                    </div>
                    <!-- END Options Zoom Out -->
                </div>
                <!-- END Page Content -->

            </main>
            <!-- END Main Container -->