SELECT 	e.cveexpediente,
									  	r.archivo AS 'ruta',
									  	r.cvereporte,
									  	r.noreporte,
									  	r.calificacion,
                                        r.estado
							    FROM expedientes e 
							    INNER JOIN reportes r
							    on r.cvereporte in (e.reporteuno,
							    					e.reportedos,
							    					e.reportetres)
							    WHERE cveusuario_1='12170618'
                                
                                