FROM node:18
WORKDIR /app
COPY . .
RUN npm install && npm run build
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
CMD ["/entrypoint.sh"]
