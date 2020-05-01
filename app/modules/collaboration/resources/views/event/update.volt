
            <!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                <div class="content">

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            {{ flashSession.output() }}
                            <!-- Static Labels -->
                            <div class="block">

                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Update Event</h3>
                                </div>
                                <div class="block-content">
                                    <form method="post">
                                        <input hidden name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
                                        <input hidden name="id" value="{{ event.id }}">
                                        <div class="form-group row">
                                            <div class="col-md-9">
                                                <div class="form-material">
                                                    <input type="text" class="form-control" id="name"
                                                           name="name" value="{{ event.name }}">
                                                    <label for="name">Event Name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <div class="form-material">
                                                    <textarea class="form-control" id="description"
                                                              name="description" rows="3" placeholder="Optional">{{ event.description }}</textarea>
                                                    <label for="description">Description</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <div class="form-material">
                                                    <input type="text" class="js-datepicker form-control" id="start_date"
                                                           name="start_date" data-week-start="1" data-autoclose="true"
                                                           data-today-highlight="true" data-date-format="yyyy-mm-dd"
                                                           placeholder="yyyy-mm-dd" value="{{ event.start_date }}">
                                                    <label for="start_date">Start Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-material">
                                                    <input type="text" class="js-masked-time form-control"
                                                           id="start_time" name="start_time" placeholder="__:__"
                                                           value="{{ event.start_time }}">
                                                    <label for="start_time">Start Time</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <div class="form-material">
                                                    <input type="text" class="js-datepicker form-control" id="end_date"
                                                           name="end_date" data-week-start="1" data-autoclose="true"
                                                           data-today-highlight="true" data-date-format="yyyy-mm-dd"
                                                           placeholder="yyyy-mm-dd" value="{{ event.end_date }}">
                                                    <label for="end_date">End Date</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-material">
                                                    <input type="text" class="js-masked-time form-control"
                                                           id="end_time" name="end_time" placeholder="__:__"
                                                           value="{{ event.end_time }}">
                                                    <label for="end_time">End Time</label>
                                                </div>
                                            </div>
                                        </div>
                                        {% if auth.role == constant('Dengarin\Main\Models\User::ROLE_SOUND') %}
                                        <div class="form-group row">
                                            <div class="col-md-9">
                                                <div class="form-material">
                                                    <select class="form-control" id="status" name="status">
                                                        <option></option>
                                                        <option {% if event.isStatus(constant('Dengarin\Collaboration\Models\Event::STATUS_FOLLOWED_UP'))
                                                            and not event.isStatus(constant('Dengarin\Collaboration\Models\Event::STATUS_ACCEPTED')) %}
                                                                selected
                                                            {% endif %} value="0">
                                                            Rejected
                                                        </option>
                                                        <option {% if event.isStatus(constant('Dengarin\Collaboration\Models\Event::STATUS_FOLLOWED_UP'))
                                                            and event.isStatus(constant('Dengarin\Collaboration\Models\Event::STATUS_ACCEPTED')) %}
                                                                selected
                                                            {% endif %} value="1">
                                                            Accepted
                                                        </option>
                                                    </select>
                                                    <label for="material-select">Status</label>
                                                </div>
                                            </div>
                                        </div>
                                        {% endif %}
                                        <div class="form-group row">
                                            <div class="col-md-9">
                                                <div class="form-material">
                                                    <input type="text" class="form-control" id="location"
                                                           name="location" value="{{ event.location }}">
                                                    <label for="location">Location</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-9">
                                                <button type="submit" class="btn btn-alt-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END Static Labels -->
                        </div>
                    </div>

                </div>
                <!-- END Page Content -->

            </main>
            <!-- END Main Container -->