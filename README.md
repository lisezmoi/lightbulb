# Lightbulb

Lightbulb is a very light CMS.

```
(~)
 #
```

## Installation

- Copy `config.example.php` to `config.php`.
- Replace the values with yours.
- If you’re running Apache and the website location is not `/`, change it in the `.htaccess` file.

## Usage

- Add your titles / image couples to the `posts.txt` file.
- Optionally, run `/cache.php` after each posts.txt edit, to update the image dimensions cache. Make sure that the `cache.db` file can be written by the server.

## License

Lightbulb is licensed under the GPLv3 (or later), see the [LICENSE file](https://github.com/lisezmoi/lightbulb/blob/master/LICENSE) for details.
