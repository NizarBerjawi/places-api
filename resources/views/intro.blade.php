@extends('layouts.base')

@section('content')
    <section class="section">
        <div class="columns">
            <div class="column is-3">
                <aside class="menu is-hidden-mobile" style="position: fixed;">
                    <p class="menu-label">
                        Places API
                    </p>
                    <ul class="menu-list">
                        <li><a href="#introduction">Introduction</a></li>
                        <li><a href="#authentication">Authentication</a></li>

                        <li><a href="#querying-relations">Querying Relations</a></li>
                        <li>
                            <a href="#filtering-relations">Filtering results</a>
                            <ul>
                                <li><a href="#filtering-relations-operators">Operators</a></li>
                            </ul>
                        </li>
                        <li><a href="#sorting-results">Sorting results</a>
                        <li><a href="#pagination">Pagination</a></li>
                        <li><a href="#rate-limiting">Rate-Limiting</a></li>
                        <li><a href="#additional-resources">Additional Resources</a></li>
                    </ul>
                </aside>
            </div>
            <div class="column is-6">
                <div class="content">
                    <h1 id="introduction">Introduction</h1>
                    <p>
                        Places API is a RESTful API based on the <a href="https://www.geonames.org/">Geonames</a>
                        database.
                    </p>

                    <blockquote>
                        The GeoNames geographical database covers all countries and contains over eleven million
                        placenames that are
                        available for download free of charge.
                    </blockquote>

                    <p>The Places API utilizes Geonames' data dumps to provide its services.</p>

                    <p>
                        These data dumps are automatically downloaded and parsed on a daily basis.
                        The data is then cleaned up and exposed through an expressive and RESTful API.
                    </p>

                    <p class="is-italic has-text-weight-semibold">If you enjoy using the API, please consider supporting me:
                    </p>

                    <div class="is-flex is-justify-content-center">
                        <script type="text/javascript" src="https://cdnjs.buymeacoffee.com/1.0.0/button.prod.min.js" data-name="bmc-button"
                            data-slug="placesApi" data-color="#FFDD00" data-emoji="" data-font="Cookie" data-text="Buy me a coffee"
                            data-outline-color="#000000" data-font-color="#000000" data-coffee-color="#ffffff"></script>
                    </div>
                    <h1 id="authentication">Authentication</h1>

                    <article class="message is-danger">
                        <div class="message-body">
                            Standard accounts can only have up to 3 API access tokens.
                        </div>
                    </article>

                    <p>The Places API authenticates your API requests using your account's API keys. If a request
                        doesn't include
                        a valid key, Places API returns an authentication error.</p>

                    <p>You can use the <a href="{{ route('login') }}">dashboard</a> to create, delete, and regenerate
                        API keys.
                    <p>
                        Authentication to the API is performed via <a
                            href="https://swagger.io/docs/specification/authentication/bearer-authentication/">HTTP
                            Bearer Auth</a>. When making requests using API tokens, the token should be included in the
                        Authorization header as a Bearer token:
                    </p>

                    <pre>Authorization: Bearer &lt;TOKEN&gt;</pre>

                    <h1 id="rate-limiting">Rate-Limiting</h1>
                    <p>At this point in time, users can make a <code>15</code> requests per minute to the API
                        before getting rate-limited.</p>

                    <p>You can determine how many requests you have remaining by inspecting the Response Headers of
                        your Request:</p>

                    <pre>X-RateLimit-Limit: 100&#010;X-RateLimit-Remaining: 65</pre>
                    <h1 id="querying-relateions">Querying Relations</h1>
                    <p>You can query a relation by adding the <code>include</code> query parameter to the request.
                    </p>
                    <p>Let's say you need to get all
                        countries with their respective languages, then your request would look like this:
                        <pre>GET /api/v1/countries?include=languages</pre>
                    <p>You can also query multiple relations by comma-separating the relations in the query string.
                        <pre>GET /api/v1/countries?include=languages,neighbours,flag</pre>

                    <h1 id="filtering-relations">Filtering Results</h1>
                    <p>To filter a result set, you can add the <code>filter</code> query parameter to the request.
                    </p>

                    <p>For example, the following request returns all the place names in Australia (AU) that have a
                        feature code of
                        ADM1 (first-order administrative division).</p>

                    <pre>GET /api/v1/countries/AU/places?filter[featureCode][eq]=ADM1</pre>

                    <p>You can combine multiple filters to get a more specfic result set.</p>
                    <pre>GET /api/v1/countries/AU/places?filter[featureCode][eq]=FLLS&filter[name][eq]=Wallaman Falls&include=location</pre>
                    <p>The above request will return any waterfalls (FLLS) having the name Wallaman Falls in
                        Australia.
                        It also includes the location of the place in the response.</p>

                    <h4 id="filtering-relations-operators">Operators</h4>

                    <p>Some of the available endpoints allow you to scope results using comparison operators. For
                        example:</p>

                    <pre>GET /api/v1/countries/AU/places?filter[featureCode][eq]=ADM1&filter[population][gte]=2000000</pre>

                    <p>The above request will return all Australian states that have a population <i>greater than or
                            equal</i> to 2000000.</p>

                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Operator</th>
                                    <th>Description</th>
                                    <th>Example</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>eq</b></td>
                                    <td>equals</td>
                                    <td><code>?filter[area][eq]=100000</code> </td>
                                </tr>
                                <tr>
                                    <td><b>neq</b></td>
                                    <td>not equal</td>
                                    <td><code>?filter[popultion][neq]=100000</code> </td>
                                </tr>
                                <tr>
                                    <td><b>gt</b></td>
                                    <td>greater than</td>
                                    <td><code>?filter[popultion][gt]=1000000</code> </td>
                                </tr>
                                <tr>
                                    <td><b>lt</b></td>
                                    <td>less than</td>
                                    <td><code>?filter[popultion][lt]=1000000</code></td>
                                </tr>
                                <tr>
                                    <td><b>gte</b></td>
                                    <td>greater than or equal</td>
                                    <td><code>?filter[popultion][gte]=1000000</code></td>
                                </tr>
                                <tr>
                                    <td><b>lte</b></td>
                                    <td>less than or equal</td>
                                    <td><code>?filter[popultion][lte]=1000000</code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Operator</th>
                                    <th>Description</th>
                                    <th>Example</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>OR</td>
                                    <td>comma-separated filters</td>
                                    <td><code>?filter[featureCode][eq]=ADM1,ADM2,ADM3</code></td>
                                </tr>
                                <tr>
                                    <td>AND</td>
                                    <td>separate filters</td>
                                    <td><code>?filter[featureCode][eq]=MT&filter[countryCode][eq]=FR&filter[elevation][gt]=3000</code>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h1 id="sorting-results">Sorting results</h1>
                    <p>All API results are sorted by their primary key by default. However, you are free to change
                        the
                        sort criteria
                        by adding the <code>sort</code> query parameter to the request.
                        <pre>GET /api/v1/countries?sort=population</pre>
                    <p>The above request will return all the countries sorted by <code>population</code> in
                        ascending
                        order.</p>
                    <p>To sort in descending order, simply add a <code>-</code> to the sort paramter.</p>
                    <pre>GET /api/v1/countries?sort=-population</pre>
                    <p>The above request will return all the countries sorted by <code>population</code> in
                        descending
                        order.</p>

                    <p>It is also possible to sort by multiple criteria by adding comma-separated sort parameters.
                    </p>
                    <pre>GET /api/v1/countries?sort=population,iso3166Alpha2</pre>


                    <h1 id="pagination">Pagination</h1>
                    <p>By default, all API results are paginated with a total of 10 results per page. You can fetch
                        the
                        data on different pages by adding the <code>page[cursor]</code> query parameter to the
                        request.
                        <pre>GET /api/v1/featureCodes?page[cursor]=eyJpc28zMTY2X2FscGhhMiI6IkFXIiwiX3BvaW50c1RvTmV4dEl0ZW1zIjp0cnVlfQ</pre>
                    <p>The above request will return all the results on the 3rd page.</p>

                    <p>You can control the number of items per page using the <code>page[size]</code> query
                        parameter.
                    </p>
                    <pre>GET /api/v1/featureCodes?page[size]=5&page[cursor]=eyJpc28zMTY2X2FscGhhMiI6IkFXIiwiX3BvaW50c1RvTmV4dEl0ZW1zIjp0cnVlfQ</pre>

                    <p>To improve the performance of the API, some pagination meta data is not computed</p>

                    <h1 id="additional-resources">Additional Resources</h1>

                    <ul>
                        <li><a href="{{ route('continents') }}">Continents</a></li>
                        <li><a href="{{ route('countries') }}">Countries</a></li>
                        <li><a href="{{ route('featureCodes') }}">Feature Codes</a></li>
                        <li><a href="{{ route('timeZones') }}">Time Zones</a></li>
                        <li><a href="{{ route('languages') }}">Languages</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>
@endsection
