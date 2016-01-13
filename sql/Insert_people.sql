INSERT INTO [dbo].[people]
           ([first_name]
           ,[last_name]
           ,[phone_number]
           ,[email]
           ,[address_1]
           ,[address_2]
           ,[city]
           ,[state]
           ,[zip]
           ,[country]
           ,[comments]
           ,[create_dt])
     VALUES
           ('Administrator'
           ,''
           ,''
           ,'admin@globalbangunan.com'
           ,''
           ,''
           ,'Pekanbaru'
           ,''
           ,''
           ,''
           ,''
           ,GETDATE())
GO


