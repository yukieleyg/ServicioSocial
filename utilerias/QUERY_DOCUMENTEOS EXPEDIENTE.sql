SELECT 	e.cveexpediente,
									  	d.archivo AS 'ruta',
									  	d.cvedocumento,
									  	d.tipo,
									  	d.revisado 
							    FROM expedientes e 
							    INNER JOIN documentos d 
							    on d.cvedocumento in (e.cartaacep,
							    					e.plantrabajo,
							    					e.cartatermina)
							    WHERE cveusuario_1='12170618'