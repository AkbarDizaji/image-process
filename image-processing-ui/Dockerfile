FROM node:lts-alpine

# Install simple http server for serving static content
RUN npm install -g http-server

# Set the working directory to /app
WORKDIR /app

# Copy both 'package.json' and 'package-lock.json' (if available)
COPY package*.json ./

# Install project dependencies
RUN npm install

# Copy project files and folders to the current working directory (/app)
COPY . .

# Expose port 8080
EXPOSE 8080

# Run the application using 'npm run serve'
CMD [ "npm", "run", "serve" ]