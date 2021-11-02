<!-- PROJECT LOGO -->
<br />
<p align="center">
  <h3 align="center">Places API</h3>

  <p align="center">
    A RESTful places API built using Lumen micro-framework.
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
   docker-compose -f docker-compose.dev.yml run --rm composer install  
   ```
4. Install npm packages
   ```sh
   docker-compose -f docker-compose.dev.yml run --rm npm install  
   ```
5. Generate Open API spec
   ```sh
   docker-compose -f docker-compose.dev.yml run --rm artisan docs:generate  
   ```
4. Build assets
   ```sh
   docker-compose -f docker-compose.dev.yml run --rm npm run build  
   ```
5. Migrate the database 
   ```sh
   docker-compose -f docker-compose.dev.yml run --rm artisan migrate  
   ```
6. Push the file download jobs to the queue
   ```sh
   docker-compose -f docker-compose.dev.yml run --rm artisan geonames:download 
   ```
   Then process the queue:
   ```sh
   docker-compose -f docker-compose.dev.yml run --rm artisan queue:work --stop-when-empty --queue=download-data,download-places,download-flags,download-names 
   ```

7. When all the files have been downloaded, push the file import jobs to the queue
   ```sh
   docker-compose -f docker-compose.dev.yml run --rm php php artisan geonames:import  
   ```
   Then process the queue:
   ```sh
   docker-compose -f docker-compose.dev.yml run --rm artisan queue:work --stop-when-empty --queue=import-data,import-places,import-names 
   ```
8. Start the application server
   ```sh
   docker-compose -f docker-compose.dev.yml up --build nginx
   ```
9. Open the application in a browser
   ```sh
   http://localhost:8080
   ```
> Please note that downloading and importing the data will download ALL the Geonames dump export files and then imports them into the database. Depending on your CPU power, This process could take up to several hours to complete.

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
- [Lumen Micro-framework](https://lumen.laravel.com/)
