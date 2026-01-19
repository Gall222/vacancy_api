FROM node:20-bookworm

WORKDIR /app

# включаем corepack (pnpm уже внутри node)
RUN corepack enable

COPY package.json pnpm-lock.yaml* ./
RUN pnpm install

COPY . .

EXPOSE 3000
CMD ["pnpm", "dev"]
