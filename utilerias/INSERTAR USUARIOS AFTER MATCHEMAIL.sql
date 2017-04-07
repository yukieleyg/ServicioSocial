INSERT INTO usuarios
    (cveusuario,clave,tipousuario)
select aluctr,md5(ALUPAS),3
from sieapibd.dalumn
where alumai in ("hector_manuel_1993@hotmail.com","jesusapodacaatondo@hotmail.com", "gaxiola_damian@hotmail.com", "jesus_abraham1995@hotmail.com", "paul_millan@live.com.mx", "roberto_medina31@hotmail.com", "JOSELPANDA@gmail.com", "valeria.riodel@hotmail.com", "ruiz.ale.12@hotmail.com", "jasm.somart@hotmail.com")
on duplicate key update cveusuario=cveusuario