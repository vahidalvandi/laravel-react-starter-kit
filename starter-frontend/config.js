const env = 'dev';

const dev = {
    api_url: 'http://127.0.0.1:8000',
    env: env
};

const prod = {
    api_url: 'https://app.oncloud.net.au',
    env: env
};

const config = {
    dev,
    prod
};

export default config[env];