FROM node:18

WORKDIR /app
COPY . .

RUN npm install && npm run build
# ключевая строка — создаём volume-совместимую директорию
CMD ["sh", "-c", "cp -r dist/* /app/dist && tail -f /dev/null"]
