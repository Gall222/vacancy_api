FROM node:22-alpine

WORKDIR /app

# Установка pnpm
RUN npm i -g pnpm

# Копирование package.json и pnpm-lock.yaml для кэширования
COPY package.json pnpm-lock.yaml ./

# Установка зависимостей с обновлением lockfile, но без выполнения скриптов
RUN pnpm install --no-frozen-lockfile --ignore-scripts

# Ручной запуск необходимых скриптов сборки
RUN pnpm approve-builds --force || true
RUN pnpm rebuild


# Копирование остальных файлов проекта
COPY . .

# Генерация .nuxt после копирования всех файлов
RUN npx nuxt prepare

EXPOSE 3000


# Прямой запуск без использования скрипта
CMD ["pnpm", "dev", "--host", "--no-install"]
