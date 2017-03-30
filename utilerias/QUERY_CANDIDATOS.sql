SELECT alm.ALUCTR, 
							TRUNCATE((inf.calcac/p.placre),2) AS PORC, 
							inf.CARCVE 
							FROM DALUMN alm 
							INNER JOIN DCALUM inf on alm.ALUCTR=inf.ALUCTR and inf.calsit=1
							INNER JOIN DPLANE p on inf.PLACVE=p.PLACVE and inf.CARCVE=p.CARCVE 
							INNER JOIN DCLIST dc ON dc.ALUCTR=alm.ALUCTR 
							WHERE (dc.PDOCVE = (select PARFOL1 from DPARAM where PARCVE= 'PRDO') 
												AND alm.ALUCTR NOT IN (SELECT sol.cveusuario_1 FROM serviciosocial.solicitudes sol where estado!=2)) 
							HAVING PORC>=0.7 
							ORDER BY `PORC` DESC, alm.ALUCTR