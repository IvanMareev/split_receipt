# frontend/Dockerfile
FROM node:20 as builder
WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . ./
RUN npm run build
