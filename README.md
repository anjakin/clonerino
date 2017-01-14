# clonerino (Anja Miletic, 17024)

~ isto 4chan samo manje prijava FBI i estetike devedesetih ~

**Spirala 1**

- Mockup dio je uradjen koristeci stranicu https://app.moqups.com/ i prikazan je ocekivani izgled za dva uobicajena tipa ekrana
- Responzivnost grid viewa je postignuta koristenjem metode negativnih margina (tutorijal sa w3schools)
- Media query dio obradjuje slucajeve za dvije razlicite sirine ekrana koristenjem standardnih sirina
- Meni je vidljiv na svim podstranicama i on je obicna lista, dok je naslov stranice zamisljen kao link na pocetnu stranicu
- Implementirane su tri forme 

- U folderu Files nalaze se html i css fajlovi kao i koristene slike za koje bi trebalo postaviti path ili ih jednostavno izvuci iz foldera Images
- U folderu Mockups se nalaze sve skice za izgled stranice na mobilnim i ostalim uredjajima

**Spirala 2**

- Za implementirane forme nije potrebna neka posebna validacija, ali opet je uradjen dio za obavezna polja i format unosa, vjerovatno ce biti dodane nove forme 
- Dropdown meni je odradjen tako da sadrzi linkove na sve (zasad isplanirane) podstranice, nalazi se na mjestu liste iz prve verzije stranice
- Gallery dio je implementiran na jednoj stranici, iako nije sve popunjeno slikama (jer ne odgovara ideji stranice), klik na sliku je zumira a esc vraca nazad na stranicu
- AJAX: ostavila sam dusu na onom wamp cudu i ne zelim vise ikad ono da radim, uglavnom kod je tu samo treba valjda podesiti string kada se bude provjeravalo

**Spirala 3**

- Serijaliziraju se postovi (post->title,desc,image)
- Nakon logina moguce je promijeniti naziv i opis posta, a moguce je i izbrisati post
- Nacin na koji je brisanje implementirano osigurat ce da uvijek postoje tri posta, na neki nacin
- Nemoguce je promijeniti sliku (bit ce uradjeno kasnije kad se implementira submitanje)
- Iz inputa se eliminisu html specijalni karakteri tako da je osigurana zastita od XSS napada
- Download je omogucen samo dok traje admin sesija, logout link je na dnu stranice
- U csv fajl se stavljaju podaci o postovima, download link isto na dnu stranice
- pdf se generise i otvara se link u novom tabu/prozoru, link je pogodite gdje? Na dnu stranice! (can u tell i suck at css cause i do)
- Search je implementiran po jednom polju jer drugog polja nemam i ne mogu ga izmisliti
- OpenShift dio ce biti uradjen ako dobijem dozvolu na vrijeme

**Spirala 4**

- Kreirane tabele za admine/korisnike, postove i alt. slike
- Uradjeno je kupljenje i ubacivanje podataka u bazu, s tim da se podaci prvo moraju jednom rucno ubaciti (nije bug nego feature)
- Prije nego se podaci ubace provjerava se postoje li vec u bazi tako da nema duplikata
- Prikazuju se podaci iz baze, ukucani username i password se porede sa podacima iz baze itd.
- Implementirana je GET metoda REST servisa i dohvacaju se ili svi, ili samo neki podaci u zavisnosti od parametra, po template
- Openshift dio nije zavrsen (tehnicki nije ni pocet ali nije ni zavrsen)