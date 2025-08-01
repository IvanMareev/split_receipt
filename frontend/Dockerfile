# Stage 1: Сборка Vite-приложения
FROM node:18 as build-stage
WORKDIR /app
COPY . .
RUN npm install && npm run build

# Stage 2: Nginx для отдачи статики
FROM nginx:alpine
COPY --from=build-stage /app/build /usr/share/nginx/html
