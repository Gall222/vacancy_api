FROM node:22-alpine

WORKDIR /app

# Устанавливаем pnpm
RUN npm install -g pnpm

# Копируем package.json
COPY package.json pnpm-lock.yaml* ./

# Устанавливаем зависимости
RUN pnpm install --ignore-scripts

# Удаляем проблемные символические ссылки
RUN find node_modules -type l -delete || true

# Копируем остальные файлы
COPY . .

# Переустанавливаем зависимости для корректного создания ссылок
RUN rm -rf node_modules && pnpm install --ignore-scripts

EXPOSE 3000

CMD ["pnpm", "dev"]