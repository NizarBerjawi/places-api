@extends('layouts.base')

@section('content')
    <section class="section">
        <div class="content">
            <h1>Intro</h1>
            <p>
                Places API is a RESTful based on the <a href="https://www.geonames.org/">Geonames</a> database.
            </p>

            <blockquote>
                The GeoNames geographical database covers all countries and contains over eleven million placenames that are
                available for download free of charge.
            </blockquote>

            <h1>Available Resources</h1>

            <table class="table is-striped">
                <thead>
                    <th>Resource</th>
                    <th>Identifier</th>
                    <th>Example</th>
                    <th></th>
                </thead>
                <tbody>
                    <tr>
                        <td class="is-vcentered">Continent</td>
                        <td class="is-vcentered">Continent 2 letter code</td>
                        <td class="is-vcentered">AS, AF, EU...</td>
                        <td class="is-vcentered"></td>
                    </tr>
                    <tr>
                        <td class="is-vcentered">Country</td>
                        <td class="is-vcentered">ISO-3166 alpha2 code</td>
                        <td class="is-vcentered">AU, CN, US... </td>
                        <td class="is-vcentered"><a class="button is-info is-small"
                                href="https://www.geonames.org/countries/" target="_blank">Full List</a></td>
                    </tr>
                    <tr>
                        <td class="is-vcentered">Place</td>
                        <td class="is-vcentered">Version 4 UUID</td>
                        <td class="is-vcentered">000a20ce-69fe-40b1-9f72-30cdecd979d2</td>
                        <td class="is-vcentered"></td>
                    </tr>
                    <tr>
                        <td class="is-vcentered">Location</td>
                        <td class="is-vcentered"><strong>N/A</strong><br />You can only query a location in the context of
                            specific place.</td>
                        <td class="is-vcentered"></td>
                        <td class="is-vcentered"></td>
                    </tr>
                    <tr>
                        <td class="is-vcentered">Currency</td>
                        <td class="is-vcentered">ISO 4217 currency code</td>
                        <td class="is-vcentered">USD, AUD, EUR...</td>
                        <td class="is-vcentered"></td>
                    </tr>
                    <tr>
                        <td class="is-vcentered">Language</td>
                        <td class="is-vcentered"><strong>N/A</strong><br />You can only query some languages in the context
                            of a specific country.</td>
                        <td class="is-vcentered"></td>
                        <td class="is-vcentered"></td>
                    </tr>
                    <tr>
                        <td class="is-vcentered">Time Zone</td>
                        <td class="is-vcentered">Time zone code</td>
                        <td class="is-vcentered">Australia/Sydney, Asia/Shanghai, Europe/London</td>
                        <td class="is-vcentered"></td>
                    </tr>
                    <tr>
                        <td class="is-vcentered">Flag</td>
                        <td class="is-vcentered">ISO-3166 alpha2 Country code</td>
                        <td class="is-vcentered"></td>
                        <td class="is-vcentered"></td>
                    </tr>
                    <tr>
                        <td class="is-vcentered">Feature Class</td>
                        <td class="is-vcentered">Feature class code</td>
                        <td class="is-vcentered"></td>
                        <td class="is-vcentered">
                            <a class="button is-info is-small" href="https://www.geonames.org/export/codes.html"
                                target="_blank">Full List</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="is-vcentered">Feature Code</td>
                        <td class="is-vcentered">N/A</td>
                        <td class="is-vcentered">A, H, L...</td>
                        <td class="is-vcentered">
                            <a class="button is-info is-small" href="https://www.geonames.org/export/codes.html"
                                target="_blank">
                                Full List
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h1>Querying Relations</h1>
            <p>You can query a relation by adding the <code>include</code> query parameter to the request.</p>
            <p>Let's say you need to get all
                countries with their respective languages, then your request would look like this:
            <pre>GET api/v1/countries?include=languages</pre>
            <p>You can also query multiple relations by comma separating the relations in the query string.
            <pre>GET api/v1/countries?include=languages,neighbours,flag</pre>

            <h1>Filtering Results</h1>
            <p>To filter a result set the you need, you can add the <code>filter</code> query parameter to the request.
            </p>

            <p>For example, the following request returns all the place names in Australia (AU) that have a feature code of
                ADM1 (first-order administrative division).</p>

            <pre>GET api/v1/countries/AU/places?filter[feature_code]=ADM1</pre>

            <p>You can combine multiple filters to get a more specfic result set.
            <p>
            <pre>GET api/v1/countries/AU/places?filter[feature_code]=ADM1&filter[population_gte]=2000000</pre>
            <p>The above request will return all Australian states that have a population greater than or equal to 2000000.
            <p>

            <h1>Pagination</h1>
            <p>By default, all API results are paginated with a total of 10 results per page. You can fetch the data on
                different pages by adding the <code>page</code> query parameter to the request.
            <pre>GET api/v1/featureCodes?page=3</pre>
        </div>
    </section>

@endsection
