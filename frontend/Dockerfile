FROM node:24-alpine

RUN apk add --no-cache bash curl

RUN npm install -g pnpm

WORKDIR /app

RUN chown -R node:node /app

USER node

COPY --chown=node:node package.json pnpm-lock.yaml* ./

RUN pnpm install --frozen-lockfile

COPY --chown=node:node . ./

EXPOSE 5173

CMD ["pnpm", "run", "dev", "--host"]
