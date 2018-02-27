APP za clanove -  PHP Srbija : Faza 1
===

Nacelno dogovor ce biti da radimo u Laravel-u (verzija po slobodi izbora, pretpostavljam poslednja), ukoliko vec imamo bazu, onda mozemo da se prikacimo sa novim tabelama...ukoliko nemamo pravimo novu. U svakom slucaju svaka tabela bi trebalo da bude sa prefixom `mma__` tipa `mma__Members`, `mma__Roles`, `mma__Votes`

#### 1. Potrebno je napraviti osnovni API za operacije sa clanovima

| METHOD     | PATH                             | DESCRIPTION                                                                                     |
| ---------- | -------------------------------- | ----------------------------------------------------------------------------------------------- |
| **POST**   | /members                         | ruta za pravljenje korisnika                                                                    |
| **GET**    | /members                         | izlistavanje svih korisnika                                                                     |
| **GET**    | /members/count                   | vraca broj svih clanova                                                                         |
| **GET**    | /members/{id}                    | prikazuje profilnu stranu korisnika {id} (za sad samo prikazuje formu za azuriranje)            |
| **PUT**    | /members/{id}                    | azurira podatke korisnika {id}                                                                  |
| **PUT**    | /members/{id}/membership/status  | azurira status placene / neplacene clanrine                                                     |
| **PUT**    | /members/{id}/membership/amount  | azurira vrednost uplacene clanarine                                                             |
| **PUT**    | /members/{id}/membership/ban     | banuje / odnosno uklanja ban sa profila korisnika                                               |
| **PUT**    | /members/{id}/membership/message | salje poruku clanu                                                                              |
| **DELETE** | /members/{id}                    | brisanje korisnika {id} (stim da necemo brisati korisnika nego ga postavljati na active: false) |
| **POST**   | /members/login                   | Prijava korisnika                                                                               |
| **GET**    | /members/logout                  | Izloguj korisnika / obrisi korisnikovu sesiju                                                   |
| **GET**    | /members/reset                   | Stranica za reset lozinke                                                                       |
| **POST**   | /members/reset                   | Akcija za reset lozinke                                                                         |
| **GET**    | /members/confirm                 | Potvrda email adresse                                                                           |
|            |                                  | **Ukoliko nesto nedostaje dogovoricemo se da dodamo, ovo je za sad dovoljno**                   |

#### 2. Profil baze
    -  mma__Members:
        -  id (INTEGER)
        -  first (VARCHAR 255)
        -  last (VARCHAR 255)
        -  email (VARCHAR 255)
        -  nickname (VARCHAR 255)
        -  username (VARCHAR 255)
        -  password (VARCHAR 255)
        -  password_salt
        -  password_verified (TYNIINT)
        -  active (TYNIINT)
        -  github_profile_url
        -  manualy_uploaded_biografy_file_url
        -  about_me
        -  profile_image_url
        -  created_at (DATETIME)
        -  updated_at (DATETIME)
        -  deleted_at (DATETIME)
    -  mma__Groups:
        -  id
        -  member_id
        -  label (Admin, Member, Anonimus)
        -  permission_level (1, 2, 3)
        -  created_at
        -  updated_at
        -  deleted_at
    -  mma__Section:
        -  id
        -  member_id
        -  label (Upravni odbor, Clan, Pocasni clan, HR, PR, Unfinished, Meetups)
        -  created_at
        -  updated_at
        -  deleted_at
    -  mma__Tags
        -  id
        -  member_id
        -  label
        -  description
        -  created_at
        -  updated_at
        -  deleted_at
    -  mma__Votes
        -  id
        -  member_id
        -  vote_member_id (id clana koji je vec odavno primljen)
        -  vote_member_value (-1, 0, 1 : ovim bismo samo kad uradimo SUM na polje mogli da dobijemo vrednost.. koja treba da bude veca od polovine broja clanova)
        -  status (tyniint)
        -  created_at
        -  updated_at
        -  deleted_at
    -  mma__Repos
        -  id
        -  member_id
        -  repository_url
        -  created_at
        -  updated_at
        -  deleted_at
    -  mma__Projects
        -  id
        -  member_id
        -  project_url
        -  project_logo_url ???
        -  description
        -  created_at
        -  updated_at
        -  deleted_at
    -  mma__Memberships
        -  id
        -  member_id
        -  paid (tyniint)
        -  amount (integer)
        -  is_in_depth
        -  ban_member (tyniint)
        -  created_at
        -  updated_at
        -  deleted_at

Iskreno ne mogu sad da se setim sta nam jos treba... ukoliko imate neke ideje, vi pisite pa da vidimo da li odgovara onome sto je vecina trazila...

Nacelno, sto se tice UI mozemo da iskoristimo neki vec postojeci, pa da njega reogranizujemo...
Dodatno mozemo da se dogovorimo ko ce sta da radi... ja iskreno nisam dugo bio u PHP prici, ali svakako poslednje sto sam radio je Laraval pa tako mogu da se prikljucim tamo ako odgovara. Ono sto ja radi vec par godina je pretezno node.js, najsvezije je Vue.js. Nacelno nisam CSS guru, ali se snalazim, pa ako mogu da pomognem na neki nacin vi organizujete mene. Ja cu vam pricati sta hocu od nje da napravim i to je to.

##### Sto se tice pocetne price za ovu aplikaciju.
---

Treba nam login struktura, koja ce da obuhvata registraciju, sa osnovnim poljima, tipa `username`, `password`, `email`, `about_me` pa onda kad se otvori profilna stranica onda mogu da se azuriraju i ostala polja...

Trbace nam i image upload, ali tek na profilnoj... predlazem da udruzenje napravi profil na https://cloudinary.com/ posto ce nam pojednostaviti smestanje fajlova i slika pa i igranje sa njima... a besplatno je za 75000 poseta mesecno... sto mislim da je dovoljno za nas sad...

Osim, strukture za logovanje i profilne strane, na kojoj cemo omoguciti da se azurira profilna slika i ostala polja iz profila, trebace nam i stranica kojoj ce moci da pristupi samo Admin, i to je stranica sa listom (tabelom) svih clanova,

##### Zahtevi za listu clanova:

* iznad liste bi trebalo da postoji pretraga clanova (jednostavni input i pretraga po imenu prezimenu, emailu, sektoru, mozemo da dodamo i pretragu po tagovima - sto ce nam svakako trebati kasnije)
* na toj stranici ce biti izlistano u tabeli: ***ime i prezime***, ***email***, ***kom sektoru pripada***, ***lista tagova*** (ukoliko budemo radili i pretragu po tagovima)
*  da li je clanarina placena ili ne ... odnosno kolona tabele bi trebalo da se zove `PAID` i u njoj ce biti checkbox u kojoj ce biti checkirano ako je clanarina placena, odnosno decekirano ukoliko nije...admin moze da promeni ovo stanje (checked/unchecked);
*  trebace nam jos jedna kolona u kojoj ce admin moci da azurira koliko novca je uplaceno (klikne na akciju, iskoci popup sa input-om unese vrednost i sacuva na save)
* treba nam jos jedna kolona `ACTIONS` koja ce imati sledece akcije:
    -  `BAN` : sa ovom akcijom (checkbox) Admin ce moci da banuje clana tako da ne moze da poseti svoju profilnu stranu. To ce da se desi prilikom logovanja (kad ga admin banuje treba da mu bude poslat email), ukoliko je clan banovan redirektuje se na login, sa porukom tipa  `pozovite predsednika udruzenja za konsultacije`... (videcemo mozda u buducnosti budemo napravili da se korisnik po automatizmu banuje ukoliko ne uplati clanarinu do odredjenog datuma u mesecu)
    -  `MESSAGE` kojom ce kad admin klikne da iskoci popup sa textarea i `send` i `cancel` otkuca poruku i sa send poslje email tom korisniku.

Pokusacu da prikazem tabelu neku...

| SEARCH: | pretragu tabele ne moramo da radimo na serveu moze jednostavno da se sredi na klijentu |
| ------- | -------------------------------------------------------------------------------------- |

| #   | NAME         | EMAIL                  | SECTION             | TAGS                                | PAID | AMOUNT | ACTIONS             |
| --- | ------------ | ---------------------- | ------------------- | ----------------------------------- | ---- | ------ | ------------------- |
| 1   | Nenad Sparic | sparic.nenad@gmail.com | Skupstina, HR, Clan | `FOLKLOR DANCER` `Ansible Begginer` | [x]  | 12000  | - BAN [x] - MESSAGE |
| 2   | Pera Peric   | pera.peric@gmail.com   | Clan                | `Absolute master`                   | [x]  | 12000  | - BAN []  - MESSAGE |


Posto ovde ima dosta interakcije, mozda bih ja ovaj deo mogao da uradim sa `Vue.js`, taman da vezbam malo, posto sam skoro poceo da se igram sa njim...

Dodatna ideja je da ovde postoji i akcija send to vote, gde bi se postavio satatus clana na vote (to moze samo jednom da se uradi za svakog korisnika) kad se desi ta akcija, svim (vec primljenim) clanovima se pojavi notfikacija `Vote Chalange` gde bi kad otvore `Vote` stranu mogli da procitaju nesto o korisniku i da pogledaju njegov profil i da glasaju `vote up` `vote down` `undecided` pa bi admin nakon toga video status glasanja i da na osnovu toga umesto `sent to vote` ima `accept`, `reject` gde bi se u skladu sa tim slao automatizovani email svakom tom glasanom clanu pa da on vidi da li je primljen ili nije...U svakom slucaju ukoliko je ovaj korisnik odbijen mislim da bismo trebali da ga brisemo iz baze, jer ce potencijalno pokusati da se prijavi kasnije/drugi put. Pa bi to stvorilo koliziju sa njegovim vec postojecim mailom. Ali to je za kasnije... samo sam hteo da znate da je to u perspektivi...