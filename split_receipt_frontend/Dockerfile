FROM node:20
WORKDIR /app

COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Копируем build в volume, который видит nginx
RUN mkdir -p /static && cp -r /app/dist/* /static/

CMD ["npx", "-y", "http-server", "-p", "8000", "-a", "0.0.0.0", "-c-1", "/app/dist"]
