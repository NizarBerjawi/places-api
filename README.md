<!-- PROJECT LOGO -->
<br />
<p align="center">
  <h3 align="center">Places API</h3>

  <p align="center">
    A RESTful places API built using Laravel framework.
    <br />
    <a href="https://www.placesapi.dev"><strong>API »</strong></a>
    <br />
</p>

<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#running-the-application">Running the Application</a></li>
      </ul>
    </li>
    <li><a href="#documentation">Documentation</a></li>
    <li><a href="#like-my-work">Like My Work?</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgements">Acknowledgements</a></li>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->

## About The Project

Places API is a RESTful api based on the <a href="https://www.geonames.org/">Geonames</a> database. You can use this API to explore the world!

### Built With

- [Laravel framework](https://laravel.com/)
- [Bulma](https://bulma.io/)
- [Swagger UI](https://swagger.io/tools/swagger-ui/)

<!-- GETTING STARTED -->

## Getting Started

To get a local copy up and running follow these simple example steps.

### Prerequisites

We recommend settings up and running the project using Docker and Docker Compose.

You will need:

1. PHP 8.2
2. Composer
3. Node Package Manager (NPM)
4. Docker
5. Docker Compose

### Running the Application

1. Clone the repository
   ```sh
   git clone https://github.com/NizarBerjawi/places-api.git
   ```
2. Create an .env file
   ```sh
   cp .env.example .env
   ```
3. Install composer packages
   ```sh
   docker compose run --rm composer install
   ```
4. Install npm packages
   ```sh
   docker compose run --rm npm install
   ```
5. Generate Open API spec
   ```sh
   docker compose run --rm artisan docs:generate
   ```
6. Build assets
   ```sh
   docker compose run --rm npm run build
   ```
7. Migrate the database
   ```sh
   docker compose run --rm artisan migrate:fresh
   ```
8. Generate an application key
   ```sh
   docker compose run --rm artisan key:generate
   ```
At this point you can already start up the application, however there won't be any data in the database.
To start the application without data, exit the interactive shell and jump to step `11` below, otherwise just keep on going through the steps below.

> Please note that downloading and importing the data will download ALL the Geonames dump export files and then imports them into the database. Depending on your CPU power, This process could take up to several hours to complete.

9. Push the file download jobs to the queue
   ```sh
   docker compose run --rm artisan geonames:download
   ```
   Then process the queue:
   ```sh
   docker compose run --rm artisan queue:work --stop-when-empty --queue=download-data,download-places,download-flags,download-names
   ```

10. When all the files have been downloaded, push the file import jobs to the queue
   ```sh
   docker compose run --rm artisan geonames:import
   ```
   Then process the queue:
   ```sh
   docker compose run --rm artisan queue:work --stop-when-empty --queue=import-data,import-places,import-names
   ```
11. Start the application server
    ```sh
    docker compose up --build nginx
    ```
12. Open the application in a browser
    ```sh
    http://localhost:8080
    ```

<!-- USAGE EXAMPLES -->

## Documentation

For a full details, please refer to the [Documentation](https://www.placesapi.dev/documentation).

## Like My Work?

If you like my work and find that this project helps, please support!

[!["Buy Me A Coffee"](https://www.buymeacoffee.com/assets/img/custom_images/yellow_img.png)](https://www.buymeacoffee.com/placesApi)

<!-- LICENSE -->

## License

Distributed under the MIT License. See [LICENSE.txt](https://github.com/NizarBerjawi/places-api/blob/master/LICENSE.txt) for more information.

<!-- CONTACT -->

## Contact

If you find any issues, please contact the developer:

Nizar El Berjawi - nizarberjawi12@gmail.com

<!-- ACKNOWLEDGEMENTS -->

## Acknowledgements

- [GeoNames](https://www.geonames.org/)
- [Laravel framework](https://laravel.com/)
