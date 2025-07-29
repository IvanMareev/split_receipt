# Stage 1: сборка фронтенда
FROM node:20 as builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: создаём контейнер только со статикой
FROM nginx:alpine
COPY --from=builder /app/dist /usr/share/nginx/html
