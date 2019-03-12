# Games(devon)

## REST APIs

### Player

* create player
> 127.0.0.1:8000/api/player

Sample payload
```javascript
{
	"username": "shweta@gmail.com"
	"firstname": 1234,
	"lastname": "player 4",
	"imageUri": "http://www.hdnicewallpapers.com/Walls/Big/Football/Football_Players_Alexis_Sanchez_Wallpapers.jpg"
}
```

### Team
* create team
> 127.0.0.1:8000/api/team

Sample payload
```javascript
{
	"name": "team 3",
	"logoUri": "https://image.freepik.com/free-vector/king-football-logo_21010-8.jpg",
	"players": [1,2,3]
}
```

* delete team 
> 127.0.0.1:8000/api/delete/team/4

* display players
> 127.0.0.1:8000/api/team/4
