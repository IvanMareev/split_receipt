# --- Stage 1: Build stage ---
FROM node:20 AS builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# --- Stage 2: Run stage ---
FROM node:20

WORKDIR /app

COPY --from=builder /app ./

# Next.js сервак
EXPOSE 3000

CMD ["npm", "start"]
