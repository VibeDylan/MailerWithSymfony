# EfficientITTestTechnique
 
 Bonjour, pour tester l'envoie de mail, j'ai utilisé l'outil mailtrap. Voici ci-joint le screeshot du mail bien reçu. 
 La configuration pour se connecter au service de mailtrap ce trouve dans le .env (mailer_dsn) 
 ```
 ###> symfony/mailer ###
MAILER_DSN=smtp://7c9b7fd4ac2944:d959de9ba244cb@smtp.mailtrap.io:2525?encryption=tls&auth_mode=login 
###< symfony/mailer ###
```
Si vous souhaitez tester l'envoie de mail créer vous une clé d'api sur mailtrap et remplacer celle existante dans le .env.


![Screenshot 2021-12-26 153215](https://user-images.githubusercontent.com/68974040/147411231-6cb8cae6-a5f1-420d-a1c0-97c96421deda.png)
