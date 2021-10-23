<!-- [![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url] -->

<!-- PROJECT LOGO -->
<br />
<p align="center">
  <h3 align="center">Places API</h3>

  <p align="center">
    A RESTful places API built using Lumen micro-framework.
    <br />
    <a href="https://github.com/othneildrew/Best-README-Template"><strong>Website »</strong></a>
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
        <li><a href="#development">Development</a></li>
      </ul>
    </li>
    <li><a href="#documentation">Documentation</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgements">Acknowledgements</a></li>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->

## About The Project

Places API is a RESTful based on the <a href="https://www.geonames.org/">Geonames</a> database. You can use this API to explore the world!

### Built With

- [Lumen Micro-framework](https://lumen.laravel.com/)
- [Bulma](https://bulma.io/)

<!-- GETTING STARTED -->

## Getting Started

To get a local copy up and running follow these simple example steps.

### Prerequisites

We recommend running the project using Docker and Docker Compose.

However, you can also run the api without Docker. In that case, you need:

1. PHP 7.3 or newer
2. Composer
3. Node Package Manager (NPM)
4. Docker
5. Docker Compose

### Running the Application locally

1. Clone the repository
   ```sh
   git clone https://github.com/NizarBerjawi/places-api.git
   ```
2. Create an .env file and set `APP_ENV=production`
   ```sh
   cp .env.example .env
   ```
3. Migrate the database 
   ```sh
   docker-compose -f docker-compose.prod.yml run --rm php php artisan migrate:fresh  
   ```
4. Download all the file
   ```sh
   docker-compose -f docker-compose.prod.yml run --rm php php artisan geonames:download  
   ```
5. Import all the file
   ```sh
   docker-compose -f docker-compose.prod.yml run --rm php php artisan geonames:import  
   ```
6. Start the application server
   ```sh
   docker-compose -f docker-compose.prod.yml up --build --detach nginx
   ```
7. Open the application in a browser
   ```sh
   http://localhost:80
   ```
> Please note that downloading and importing the data will download ALL the Geonames dump export files and then imports them into the database. Depending on your CPU power, This process could take up to several hours to complete.

<!-- USAGE EXAMPLES -->

## Usage

For a full details, please refer to the [Documentation](https://placesapi.dev/documentation).

<!-- LICENSE -->

## License

Distributed under the MIT License. See `LICENSE` for more information.

<!-- CONTACT -->

## Contact

Nizar El Berjawi - nizarberjawi12@gmail.com

Project Link: [https://github.com/NizarBerjawi/places-api](https://github.com/NizarBerjawi/places-api)

<!-- ACKNOWLEDGEMENTS -->

## Acknowledgements

- [GeoNames](https://www.geonames.org/)
- [Lumen Micro-framework](https://lumen.laravel.com/)
- [Laravel-query-builder](https://spatie.be/docs/laravel-query-builder/v2/introduction)
- [Bulma](https://bulma.io/)