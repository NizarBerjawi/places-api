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
            <p>The above request will return all the results on the 3rd page.</p>

            <h1>Additional Resources</h1>

            <ul>
                <li><a href="https://www.geonames.org/countries/">Countries</a></li>
                <li><a href="https://www.geonames.org/export/codes.html">Feature Codes</a></li>
            </ul>
        </div>
    </section>

@endsection
