## About

This is a demo app showing how to integrate AWS S3 Storage into a Laravel application.

## Local Development

To build locally, use the following commands:

```bash
git clone git@github.com:shaunthornburgh/laravel-aws-s3-demo.git
cd laravel-aws-s3-demo
composer install
./vendor/bin/sail up -d
./vendor/bin/sail migrate --seed
./vendor/bin/sail npm run dev
```
