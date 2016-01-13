SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[employees](
	[username] [varchar](50) NOT NULL,
	[password] [varchar](255) NULL,
	[person_id] [int] NOT NULL,
	[deleted] [int] NOT NULL,
	[superuser] [int] NOT NULL,
	[chpasswd] [int] NOT NULL,
	[create_dt] [datetime] NULL
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[employees]  WITH CHECK ADD  CONSTRAINT [FK_employees_people] FOREIGN KEY([person_id])
REFERENCES [dbo].[people] ([person_id])
GO

ALTER TABLE [dbo].[employees] CHECK CONSTRAINT [FK_employees_people]
GO

ALTER TABLE [dbo].[employees] ADD  CONSTRAINT [DF_employees_deleted]  DEFAULT ((0)) FOR [deleted]
GO

ALTER TABLE [dbo].[employees] ADD  CONSTRAINT [DF_employees_superuser]  DEFAULT ((0)) FOR [superuser]
GO

ALTER TABLE [dbo].[employees] ADD  CONSTRAINT [DF_employees_chpasswd]  DEFAULT ((1)) FOR [chpasswd]
GO