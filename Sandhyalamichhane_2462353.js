const cityInput = document.querySelector('.city-input');
const button = document.querySelector('.button');
const weatherInfoSection = document.querySelector('.about-weather');
const countryTxt = document.querySelector('.text');
const temptext = document.querySelector('.temp-text');
const conditiontext = document.querySelector('.content-text');
const humidityvalue = document.querySelector('.humidity-value');
const windvalue = document.querySelector('.wind-value');
const date = document.querySelector('.current-text');

const apiKey = 'c6dfdc7befbb6834a1af3db387ee51d2';
const defaultCity = 'Siraha';

async function getFetchData(city) {
    try{
        const response = await fetch(`http://localhost/weatherapp2/connection.php?q=${city}`);
        if (!response.ok) throw new Error("Failed to fetch weather data");
        const data= await response.json();
        return data;}
    catch(error){
        console.error("Error fetching weather data:", error);
        }
}

async function updateWeatherInfo(city) {

    const CityName = weatherData.CityName;
    const Temperature = weatherData.Temperature;
    const Humidity = weatherData.Humidity;
    const Windspeed = weatherData.Windspeed;
    const WeatherCondition = weatherData.WeatherCondition;
     
    countryTxt.textContent = CityName;
    temptext.textContent = `${Math.round(Temperature)}°C`;
    conditiontext.textContent = WeatherCondition;
    humidityvalue.textContent = `${Humidity}%`;
    windvalue.textContent = `${Windspeed} km/h`;
    date.textContent = new Date().toDateString();
}

button.addEventListener('click', () => {
    if (cityInput.value.trim() !== '') {
        updateWeatherInfo(cityInput.value);
        cityInput.value = '';
    }
});

cityInput.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' && cityInput.value.trim() !== '') {
        updateWeatherInfo(cityInput.value);
        cityInput.value = '';
    }
});

updateWeatherInfo(defaultCity);







    







