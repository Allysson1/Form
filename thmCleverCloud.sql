
create table ocorrencia
(
IdOcorrencia int not null primary key auto_increment,
IdConsulta bigint not null,
NomeUsuario varchar(80) not null, 
LocalAlagamento  varchar(30) not null, 
IntensidadeAlagamento varchar(30) not null,
ClassificacaoAlagamento varchar(50) not null,
Data_Ocorrencia datetime default current_timestamp
);


#path = caminho
create table imagemOcorrencia
(IdImagemOcorrencia int not null primary key auto_increment,
IdConsulta int not null,
Nome varchar (100) null,
Path varchar(100) null,
data_upload datetime default current_timestamp
);


select * from ocorrencia;

select * from imagemOcorrencia;

select OC.NomeUsuario, OC.LocalAlagamento, OC.IntensidadeAlagamento,
		OC.ClassificacaoAlagamento, OC.Data_Ocorrencia, Img.Path
from ocorrencia OC inner Join imagemOcorrencia Img
on OC.IdConsulta = Img.IdConsulta