import WebApp from "@twa-dev/sdk"
import { useState } from 'react';

function App() {
  const [response, setResponse] = useState('');

  const handleSubmit = async () => {
    const tgUser = WebApp.initDataUnsafe.user;

    const res = await fetch('http://localhost:8000/api/split', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        user_id: tgUser?.id,
        name: tgUser?.first_name,
      }),
    });

    const data = await res.json();
    setResponse(JSON.stringify(data));
  };

  return (
    <>
      <h1>Telegram WebApp</h1>
      <button onClick={handleSubmit}>Send</button>
      <p>{response}</p>
    </>
  );
}

export default App;
