"use client";

import { useEffect, useState } from "react";

interface TelegramUser {
  id: number;
  first_name: string;
  last_name?: string;
  username?: string;
  language_code?: string;
  is_premium?: boolean;
  photo_url?: string;
}

export default function Home() {
  const [user, setUser] = useState<TelegramUser | null>(null);
  const [error, setError] = useState("");

  useEffect(() => {
    const tg = window.Telegram?.WebApp;

    if (!tg) {
      setError("Telegram WebApp SDK не найден");
      return;
    }

    tg.ready();

    const userData = tg.initDataUnsafe?.user;
    if (userData) {
      setUser(userData);
    } else {
      setError("Пользователь не найден");
    }

    tg.MainButton.setText("ОК");
    tg.MainButton.show();
    tg.MainButton.onClick(() => {
      tg.close();
    });
  }, []);

  if (error) return <p>{error}</p>;

  if (!user) return <p>Загрузка...</p>;

  return (
    <div style={{
      maxWidth: 300,
      margin: "40px auto",
      padding: 20,
      border: "1px solid #ccc",
      borderRadius: 10,
      fontFamily: "Arial",
      textAlign: "center",
    }}>
      {user.photo_url && (
        <img
          src={user.photo_url}
          alt="Avatar"
          style={{ borderRadius: "50%", width: 100, height: 100, objectFit: "cover", marginBottom: 10 }}
        />
      )}
      <h2>{user.first_name} {user.last_name}</h2>
      {user.username && <p>@{user.username}</p>}
      {user.language_code && <p>Язык: {user.language_code}</p>}
      {!user.is_premium && <p>💎 NOT Premium пользователь</p>}
    </div>
  );
}
