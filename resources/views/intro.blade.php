@extends('layouts.base')

@section('content')
    <section class="section">
        <div class="content">
            <h1>Introduction</h1>
            <p>
                Places API is a RESTful API based on the <a href="https://www.geonames.org/">Geonames</a> database.
            </p>

            <blockquote>
                The GeoNames geographical database covers all countries and contains over eleven million placenames that are
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
            <p>To filter a result set the you need, you can add the <code>filter</code> query parameter to the request.
            </p>

            <p>For example, the following request returns all the place names in Australia (AU) that have a feature code of
                ADM1 (first-order administrative division).</p>

            <pre>GET /api/v1/countries/AU/places?filter[feature_code]=ADM1</pre>

            <p>You can combine multiple filters to get a more specfic result set.
            <p>
            <pre>GET /api/v1/countries/AU/places?filter[feature_code]=FLLS&filter[name]=Wallaman Falls&include=location</pre>
            <p>The above request will return any waterfalls (FLLS) having the name Wallaman Falls in Australia. It also
                includes the location of the place in the response.

            <h4>Conventions</h4>
            <p>Some of the available endpoints allow you to scope results using comparison operators. For example:</p>

            <pre>GET /api/v1/countries/AU/places?filter[feature_code]=ADM1&filter[population_gte]=2000000</pre>

            <p>The above request will return all Australian states that have a population <i>greater than or equal</i> to
                2000000.
            <p>

            <table>
                <thead>
                    <tr>
                        <th>Operator</th>
                        <th>Description</th>
                        <th>Example</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>gt</b></td>
                        <td>greater than</td>
                        <td><code>popultion_gt=1000000</code> </td>
                    </tr>
                    <tr>
                        <td><b>lt</b></td>
                        <td>less than</td>
                        <td><code>popultion_lt=1000000</code></td>
                    </tr>
                    <tr>
                        <td><b>gte</b></td>
                        <td>greater than or equal</td>
                        <td><code>popultion_gte=1000000</code></td>
                    </tr>
                    <tr>
                        <td><b>lte</b></td>
                        <td>less than or equal</td>
                        <td><code>popultion_lte=1000000</code></td>
                    </tr>
                    <tr>
                        <td><b>between</b></td>
                        <td>between</td>
                        <td><code>popultion_between=100000,350000</code></td>
                    </tr>
                </tbody>
            </table>


            <h1>Pagination</h1>
            <p>By default, all API results are paginated with a total of 10 results per page. You can fetch the data on
                different pages by adding the <code>page</code> query parameter to the request.
            <pre>GET /api/v1/featureCodes?page=3</pre>
            <p>The above request will return all the results on the 3rd page.</p>

            <h1>Additional Resources</h1>

            <ul>
                <li><a href="https://www.geonames.org/countries/">Countries</a></li>
                <li><a href="https://www.geonames.org/export/codes.html">Feature Codes</a></li>
            </ul>
        </div>
    </section>

@endsection
