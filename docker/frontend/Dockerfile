FROM node:22-alpine

WORKDIR /app

# Установка pnpm
RUN npm i -g pnpm

# Копирование файлов
COPY package.json pnpm-lock.yaml .npmrc* ./

# Установка зависимостей с игнорированием lockfile
RUN pnpm install --no-frozen-lockfile --ignore-scripts

# Копирование исходников
COPY . .

# Генерация .nuxt
RUN npx nuxt prepare

EXPOSE 3000

CMD ["pnpm", "dev", "--host", "0.0.0.0"]