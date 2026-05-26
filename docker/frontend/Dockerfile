FROM node:22-alpine

WORKDIR /app

RUN npm i -g pnpm

COPY package.json pnpm-lock.yaml ./

# Обновляем lockfile перед установкой
RUN pnpm install --no-frozen-lockfile --ignore-scripts

# Ручной запуск необходимых скриптов
RUN pnpm approve-builds --force || true
RUN pnpm rebuild

# Генерация .nuxt
RUN npx nuxt prepare

COPY . .

# Обновляем lockfile с учетом всех изменений
RUN pnpm install --no-frozen-lockfile

EXPOSE 3000

CMD ["pnpm", "dev", "--host", "--no-install"]