# github-pages-send-mail

Server-side PHP code for emailing contact form from GitHub pages or other site.
The code is deployed on [Heroku](https://heroku.com) and uses SendGrid to send emails.

## How to use

### Prerequisites

You should have an account on Heroku. For a small web-site a free acount should be sufficient.
If you are new to Heroku read their [Getting Started Guide](https://devcenter.heroku.com/articles/getting-started-with-php).

Sign up for [SendGrid](https://sendgrid.com/) and create an API key.

### Installation

Clone a repository and create a new Heroku application.

### Heroku configuration

Under application settings define the following `Config Vars`:

```
ALLOWED_ORIGIN          <your domain address>
RECIPIENT_EMAIL         <your email address>
RECEPIENT_NAME          <your name>
SENDGRID_API_KEY        <the API key that you created on SendGrid>
```

### Client code

See the code in `example/contact.html` for a minimum example of a contact form.
