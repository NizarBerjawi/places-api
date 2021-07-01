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
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgements">Acknowledgements</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

Places API is a RESTful based on the <a href="https://www.geonames.org/">Geonames</a> database. You can use this API to explore the world!

### Built With

* [Lumen Micro-framework](https://lumen.laravel.com/)
* [Bulma](https://bulma.io/)


<!-- GETTING STARTED -->
## Getting Started

To get a local copy up and running follow these simple example steps.

### Prerequisites

We recommend running the project using Docker and Docker Compose.

However, you can also run the api without Docker. In that case, you need:

1. PHP 7.3 or newer
2. Composer
3. Node Package Manager (NPM)

### Installation

Using Docker and docker-compose:

1. Clone the repository
   ```sh
   git clone https://github.com/NizarBerjawi/places-api.git
   ```
2. Create a .env file
   ```sh
   cp .env.example .env
   ```
3. Install composer packages
   ```sh
   docker-compose run --rm composer install
   ```
4. Install NPM packages
   ```sh
   docker-compose run --rm npm install
   ```
5. Start the application server
   ```sh
   docker-compose up --build nginx
   ```
6. Migrate the database
   ```sh
   docker-compose run --rm artisan migrate
   ```
7. Download Geonames files and seed the database
   ```sh
   docker-compose run --rm artisan db:seed
   ```
8. Open the application in a browser
   ```sh
   http://localhost:8080
   ```


> Please note that seeding the database will download ALL the Geonames dump export files and then imports them into the database. This process could take several hours to complete.

<!-- USAGE EXAMPLES -->
## Usage

For a full details, please refer to the [Documentation](https://example.com).
   
<!-- LICENSE -->
## License
Distributed under the MIT License. See `LICENSE` for more information.

<!-- CONTACT -->
## Contact
Nizar El Berjawi - nizarberjawi12@gmail.com

Project Link: [https://github.com/NizarBerjawi/places-api](https://github.com/NizarBerjawi/places-api)

<!-- ACKNOWLEDGEMENTS -->
## Acknowledgements
* [GeoNames](https://www.geonames.org/)
* [Laravel-query-builder](https://spatie.be/docs/laravel-query-builder/v2/introduction)
