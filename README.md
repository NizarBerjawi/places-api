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
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
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

1. PHP 7.3 
2. Composer
3. Node Package Manager (NPM)

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/NizarBerjawi/places-api.git
   ```
2. Install composer packages
   ```sh
   composer install
   ```
   or 
   
   ```sh
   docker-compose run --rm composer install
   ```
3. Install NPM packages
   ```sh
   npm install
   ```

   or 

   ```sh
   docker-compose run --rm npm install
   ```

4. Migrate the database
   ```sh
   php artisan migrate
   ```
   or 

   ```sh
   docker-compose run --rm artisan migrate
   ```
5. Download files and seed the database

   ```sh
   php artisan db:seed
   ```
   or 
   ```sh
   docker-compose run --rm artisan db:seed
   ```

> Please note that seeding the database will download ALL the Geonames dump export files and then imports them to the database. This will take quite a bit of time.

<!-- USAGE EXAMPLES -->
## Usage

Use this space to show useful examples of how a project can be used. Additional screenshots, code examples and demos work well in this space. You may also link to more resources.

_For more examples, please refer to the [Documentation](https://example.com)_


<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request



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





<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/othneildrew/Best-README-Template.svg?style=for-the-badge
[contributors-url]: https://github.com/othneildrew/Best-README-Template/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/othneildrew/Best-README-Template.svg?style=for-the-badge
[forks-url]: https://github.com/othneildrew/Best-README-Template/network/members
[stars-shield]: https://img.shields.io/github/stars/othneildrew/Best-README-Template.svg?style=for-the-badge
[stars-url]: https://github.com/othneildrew/Best-README-Template/stargazers
[issues-shield]: https://img.shields.io/github/issues/othneildrew/Best-README-Template.svg?style=for-the-badge
[issues-url]: https://github.com/othneildrew/Best-README-Template/issues
[license-shield]: https://img.shields.io/github/license/othneildrew/Best-README-Template.svg?style=for-the-badge
[license-url]: https://github.com/othneildrew/Best-README-Template/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/othneildrew
[product-screenshot]: images/screenshot.png
