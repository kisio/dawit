const express = require('express');
const axios = require('axios');

const app = express();
const port = 3000;

app.use(express.urlencoded({ extended: true })); // Parse form data

app.get('/', (req, res) => {
  // Display the form for user input
  const html = `
    <html>
      <head>
        <title>Weather App</title>
      </head>
      <body>
        <h1>Search for City Weather</h1>
        <form action="/weather" method="post">
          <label for="city">City:</label>
          <input type="text" id="city" name="city" required><br>

          <button type="submit">Get Weather</button>
        </form>
      </body>
    </html>
  `;

  res.send(html);
});

app.post('/weather', async (req, res) => {
  try {
    const city = req.body.city;
    const apiKey = process.env.API_KEY;
    
    const weatherURL = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}`;

    const response = await axios.get(weatherURL);
    const weatherData = response.data;

    // Render the fetched weather data on the HTML page
    const html = `
      <html>
        <head>
          <title>Weather Information</title>
        </head>
        <body>
          <h1>Weather Information for ${city}</h1>
          <p>Location: ${weatherData.name}, ${weatherData.sys.country}</p>
          <p>Weather: ${weatherData.weather[0].description}</p>
          <p>Temperature: ${weatherData.main.temp} K</p>
        </body>
      </html>
    `;

    res.send(html);
  } catch (error) {
    res.status(500).send('Error fetching weather data.');
  }
});

app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
