@extends('layouts.base')

@section('content')
    <div class="container">
        <section class="section">
            <div class="content">
                <div class="columns">
                    <div class="column is-10 is-offset-1">
                        <h1>Introduction</h1>
                        <p>
                            Places API is a RESTful API based on the <a href="https://www.geonames.org/">Geonames</a>
                            database.
                        </p>

                        <blockquote>
                            The GeoNames geographical database covers all countries and contains over eleven million
                            placenames that are
                            available for download free of charge.
                        </blockquote>

                        <h1>Querying Relations</h1>
                        <p>You can query a relation by adding the <code>include</code> query parameter to the request.</p>
                        <p>Let's say you need to get all
                            countries with their respective languages, then your request would look like this:
                        <pre>GET /api/v1/countries?include=languages</pre>
                        <p>You can also query multiple relations by comma-separating the relations in the query string.
                        <pre>GET /api/v1/countries?include=languages,neighbours,flag</pre>

                        <h1>Filtering Results</h1>
                        <p>To filter a result set, you can add the <code>filter</code> query parameter to the request.
                        </p>

                        <p>For example, the following request returns all the place names in Australia (AU) that have a
                            feature code of
                            ADM1 (first-order administrative division).</p>

                        <pre>GET /api/v1/countries/AU/places?filter[featureCode]=ADM1</pre>

                        <p>You can combine multiple filters to get a more specfic result set.
                        <p>
                        <pre>GET /api/v1/countries/AU/places?filter[featureCode]=FLLS&filter[name]=Wallaman Falls&include=location</pre>
                        <p>The above request will return any waterfalls (FLLS) having the name Wallaman Falls in Australia.
                            It also
                            includes the location of the place in the response.

                        <h4>Conventions</h4>

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
                                        <td><code>?filter[featureCode]=ADM1,ADM2,ADM3</code></td>
                                    </tr>
                                    <tr>
                                        <td>AND</td>
                                        <td>separate filters</td>
                                        <td><code>?filter[featureCode]=MT&filter[countryCode]=FR&filter[elevationGt]=3000</code>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p>Some of the available endpoints allow you to scope results using comparison operators. For
                            example:</p>

                        <pre>GET /api/v1/countries/AU/places?filter[featureCode]=ADM1&filter[populationGte]=2000000</pre>

                        <p>The above request will return all Australian states that have a population <i>greater than or
                                equal</i> to
                            2000000.
                        <p>

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
                                        <td><b>Gt</b></td>
                                        <td>greater than</td>
                                        <td><code>?filter[popultionGt]=1000000</code> </td>
                                    </tr>
                                    <tr>
                                        <td><b>Lt</b></td>
                                        <td>less than</td>
                                        <td><code>?filter[popultionLt]=1000000</code></td>
                                    </tr>
                                    <tr>
                                        <td><b>Gte</b></td>
                                        <td>greater than or equal</td>
                                        <td><code>?filter[popultionGte]=1000000</code></td>
                                    </tr>
                                    <tr>
                                        <td><b>Lte</b></td>
                                        <td>less than or equal</td>
                                        <td><code>?filter[popultionLte]=1000000</code></td>
                                    </tr>
                                    <tr>
                                        <td><b>Between</b></td>
                                        <td>between</td>
                                        <td><code>?filter[popultionBetween]=100000,350000</code></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h1>Sorting</h1>
                        <p>All API results are sorted by their primary key by default. However, you are free to change the
                            sort criteria
                            by adding the <code>sort</code> query parameter to the request.
                        <pre>GET /api/v1/countries?sort=population</pre>
                        <p>The above request will return all the countries sorted by <code>population</code> in ascending
                            order.</p>
                        <p>To sort in descending order, simply add a <code>-</code> to the sort paramter.</p>
                        <pre>GET /api/v1/countries?sort=-population</pre>
                        <p>The above request will return all the countries sorted by <code>population</code> in descending
                            order.</p>

                        <p>It is also possible to sort by multiple criteria by adding comma-separated sort parameters.</p>
                        <pre>GET /api/v1/countries?sort=population,iso3166Alpha2</pre>


                        <h1>Pagination</h1>
                        <p>By default, all API results are paginated with a total of 10 results per page. You can fetch the
                            data on
                            different pages by adding the <code>page[number]</code> query parameter to the request.
                        <pre>GET /api/v1/featureCodes?page[number]=3</pre>
                        <p>The above request will return all the results on the 3rd page.</p>

                        <p> You can control the number of items per page using the <code>page[size]</code> query parameter.
                        </p>
                        <pre>GET /api/v1/featureCodes?page[number]=3&page[size]=5</pre>

                        <h1>Rate-Limiting</h1>
                        <p>At this point in time, users can make a <code>100</code> requests per minute to the API before
                            getting
                            rate-limited.</p>

                        <p>You can determine how many requests you have remaining by inspecting the Response Headers of your
                            Request:</p>

                        <pre>X-RateLimit-Limit: 100&#010;X-RateLimit-Remaining: 65</pre>

                        <h1>Additional Resources</h1>

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
    </div>
@endsection
