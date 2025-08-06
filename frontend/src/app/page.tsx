"use client";

import { useEffect, useState } from "react";
import WebApp from "@telegram-apps/sdk";

export default function Home() {
  const [userInfo, setUserInfo] = useState("Telegram WebApp не инициализирован");

  useEffect(() => {
    WebApp.ready(); // сообщает Telegram, что приложение готово

    const user = WebApp.initDataUnsafe?.user;
    if (user) {
      setUserInfo(`Привет, ${user.first_name} (@${user.username || "без username"})`);
    } else {
      setUserInfo("Не удалось получить пользователя из initData");
    }

    // Пример: изменение главной кнопки
    WebApp.MainButton.setText("Готово");
    WebApp.MainButton.show();
    WebApp.MainButton.onClick(() => {
      alert("Кнопка нажата!");
      WebApp.close();
    });
  }, []);

  return (
    <div className="font-sans grid grid-rows-[20px_1fr_20px] items-center justify-items-center min-h-screen p-8 pb-20 gap-16 sm:p-20">
      <main className="flex flex-col gap-[32px] row-start-2 items-center sm:items-start">
        <pre>{userInfo}</pre>
      </main>
    </div>
  );
}
