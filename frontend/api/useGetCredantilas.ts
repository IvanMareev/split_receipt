import axios from 'axios';
import TelegramUser from '../types/telegramUser';

const BACKEND_HOST = process.env.BACKEND_HOST;

const getCredentials = async (user: TelegramUser): Promise<string> => {
  try {
    const response = await axios.get(`https://jubilant-cod-wrv454vqq7q5c95wr-9000.app.github.dev/api/auth/telegram`, {params: user} );
    return response.data;
  } catch (error) {
    // console.error('Error fetching credentials:', error);
    return JSON.stringify(error);
  }
};

export default getCredentials;

