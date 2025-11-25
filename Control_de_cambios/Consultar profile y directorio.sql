--select * from [lgxuCI803].[dbo].[ph_contact_profile]  where code =7970236;
select top 1 * from [lgxuCI803].[dbo].[ph_contact_profile]  where unique_id='000000460029' order by last_update desc;
select * from [lgxuCI803].[dbo].[dir_Falabella_Recovery] where easycode=8093493;

select * from ph_contact_profile as ph 
inner join dir_Falabella_Recovery as back on ph.code=back.easycode
where ph.unique_id  ='000000460029' and back.activo=0
